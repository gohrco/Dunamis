<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Config Class for Kayako
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.1.0
 */
class KayakoDunConfig extends DunObject
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.1.0
	 */
	public function __construct()
	{
		$this->load();
		$this->sessionLoad();
	}
	
	
	/**
	 * Getter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being sought
	 * 
	 * @return		mixed value of setting or false
	 * @since		1.1.0
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
	 * @since		1.1.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
				
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunConfig';
				$instance	= new $classname();
			}
			else {
				$instance = new self( $options );
			}
		}
	
		return $instance;
	}
	
	
	/**
	 * Loader method
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.1.0
	 */
	public function load()
	{
		$db = dunloader( 'database', true );
		
		$db->setQuery( "SELECT `vkey` as `setting`, `data` as `value` FROM `swsettings` WHERE `section` IN ( 'settings', 'core' )" );
		$items	= $db->loadObjectList();
		
		foreach ( $items as $item ) $this->set( $item->setting, $item->value );
	}
	
	
	/**
	 * Method to refresh the data from the database
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.1.0
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
	 * @since		1.1.0
	 */
	public function sessionLoad()
	{
// 		global $whmcs;
		
// 		if (! isset( $whmcs->config ) ) return;
		
// 		$items	= $whmcs->config;
// 		foreach ( $items as $k => $v ) $this->set( $k, $v );
	}
	
	
	/**
	 * Setter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being set
	 * @param		mixed		- $value: the value to set
	 * 
	 * @since		1.1.0
	 */
	public function set( $item, $value )
	{
		$this->$item = $value;
	}
}