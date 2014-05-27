<?php
/**
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Dunamis Configuration handler for WHMCS
 * @desc		This grabs configuration settings from WHMCS for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunConfig extends DunObject
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		if (! isset( $options['database'] ) )	$options['database'] = true;
		if (! isset( $options['session'] ) )	$options['session'] = true;
		
		if ( $options['database'] ) {
			$this->load();
		}
		
		if ( $options['session'] ) {
			$this->sessionLoad();
		}
	}
	
	
	/**
	 * Getter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being sought
	 * 
	 * @return		mixed value of setting or false
	 * @since		1.0.0
	 */
	public function get( $item )
	{
		if ( $this->$item ) {
			return $this->$item;
		}
		else return false;
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
				
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunConfig';
				$instance	= new $classname( $options );
			}
			else {
				$instance = new self( $options );
			}
		}
	
		return $instance;
	}
	
	
	/**
	 * Method to determine if the config has a variable available
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $item: the variable item we are looking for
	 *
	 * @return		boolean
	 * @since		1.1.5
	 */
	public function has( $item )
	{
		return ( isset( $this->$item ) ? true : false );
	} 
	
	
	/**
	 * Loader method
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function load()
	{
		$db = dunloader( 'database', true );
		
		$db->setQuery( 'SELECT * FROM tblconfiguration' );
		$items	= $db->loadObjectList();
		
		foreach ( $items as $item ) $this->set( $item->setting, $item->value );
	}
	
	
	/**
	 * Method to refresh the data from the database
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function refresh()
	{
		$this->load();
	}
	
	
	/**
	 * Loads the session variables over top our object variables
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.1
	 */
	public function sessionLoad()
	{
		global $whmcs;
		
		if ( isset( $whmcs->config ) ) {
			$items	=	$whmcs->config;
		}
		else if ( isset( $GLOBALS['CONFIG'] ) ) {
			$items	=	$GLOBALS['CONFIG'];
		}
		else {
			return;
		}
		
		foreach ( $items as $k => $v ) $this->set( $k, $v );
	}
	
	
	/**
	 * Setter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being set
	 * @param		mixed		- $value: the value to set
	 * 
	 * @since		1.0.0
	 */
	public function set( $item, $value )
	{
		$this->$item = $value;
	}
}