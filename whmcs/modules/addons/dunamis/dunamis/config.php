<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @projectName@
 * Integrator 3 - Configuration Handler File
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      3.1.00
 *
 * @desc       This file is the configuration handler
 *
 */


/**
 * Configuration Class for Dunamis
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.4.0
 */
class DunamisDunConfig extends WhmcsDunConfig
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		3.1.00
	 */
	public function __construct()
	{
		parent :: __construct();
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		3.1.00
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
			$instance = new DunamisDunConfig( $options );
		}
	
		return $instance;
	}
	
	
	/**
	 * Method to gather values for the form to work from
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		boolean		- $reload: if we need to reload to ensure we have latest
	 * 
	 * @return		array
	 * @since		3.1.00
	 */
	public function getValues( $reload = false )
	{
		// If we reload, then do so
		if ( $reload ) {
			$this->load();
		}
		
		$configs	=	dunmodule( 'dunamis.install' )->getConfiguration( 'settings' );
		$vars		=	get_object_vars( $this );
		
		foreach ( $configs as $k => $v ) {
			$configs[$k]	= ( isset( $vars[$k] ) ? $vars[$k] : $v );
		}
		
		return $configs;
	}
	
	
	/**
	 * Loader method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		3.1.00
	 */
	public function load()
	{
		$db = dunloader( 'database', true );
		$db->setQuery( "SELECT * FROM mod_dunamis_settings" );
		$items	= $db->loadObjectList();
		
		foreach ( $items as $item ) $this->set( $item->key, $item->value );
	}
	
	
	/**
	 * Save method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		3.1.00
	 */
	public function save()
	{
		$db		=	dunloader( 'database', true );
		$values	=	$this->getValues();
		
		foreach ( $values as $key => $value ) {
			
			if ( $key == 'apitoken' && ! $this->saveAutoauthKey( $value ) ) {
				continue;
			}
			
			$query	=	"SELECT `key` FROM `mod_dunamis_settings` WHERE `key` = " . $db->Quote( $key );
			$db->setQuery( $query );
			
			if ( $db->loadResult() ) {
				$query	=	"UPDATE `mod_dunamis_settings` SET `value` = " . $db->Quote( $value ) . " WHERE `key` = " . $db->Quote( $key );
			}
			else {
				$query	=	"INSERT INTO `mod_dunamis_settings` ( `key`, `value` ) VALUES ( " . $db->Quote( $key ) . ", " . $db->Quote( $value ) . ")";
			}
			
			$db->setQuery( $query );
			$db->query();
		}
		
		return true;
	}
	
	
	/**
	 * Method for saving the updated key
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $default: the value we are saving (optional)
	 *
	 * @return		boolean
	 * @since		3.1.00
	 */
	public function saveAutoauthKey( $value =  null )
	{
		$configfile	=	DUN_ENV_PATH . 'configuration.php';
		$default	=	dunloader( 'config', 'integrator' )->get( 'apitoken', null );
		
		if (! file_exists( $configfile ) ) {
			return $default;
		}
		
		$content	=	@file_get_contents( $configfile );
		
		// Lets blow things up
		$lines	=	explode( "\n", $content );
		$end	=
		$id		=	false;
		
		// Cycle through lines and find our points of need
		foreach ( $lines as $k => $l ) {
			// Clean up first
			$lines[$k]	=	trim( $l );
			
			if ( strpos( $l, '$autoauthkey' ) !== false ) $id	=	$k;
			if ( strpos( $l, '?>' ) !== false ) $end = $k;
		}
		
		if (! $id ) {
			if ( $end ) {
				$lines[]		=	end( $lines );
				$lines[$end]	=	'$autoauthkey = "' . $value . '";';
			}
			else {
				$lines[]	=	'$autoauthkey = "' . $value . '";';
				$lines[]	=	'?>';
			}
		}
		else {
			$lines[$id]	=	preg_replace( '#\$autoauthkey[\s=]+(["|\']+)(?P<key>[^\1]+)\1+;#im', '$autoauthkey = "' . $value . '";', $lines[$id] );
			
			if (! $end ) {
				$lines[]	=	'?>';
			}
		}
		
		foreach ( $lines as $k => $l ) {
			if ( $k == 0 || ( count( $lines ) - 1 ) == $k ) continue;
			$lines[$k] = '    ' . $l;
		}
		
		$content	=	implode( "\n", $lines );
		
		if (! @file_put_contents( $configfile, $content ) ) {
			return false;
		}
		
		return true;
	}
}