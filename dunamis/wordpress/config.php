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

defined( 'DUNAMIS' ) OR exit('No direct script access allowed');

/**
 * Dunamis Configuration class for Joomla
 * @desc		This grabs configuration settings from Wordpress wp-config.php and options datatable for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Wordpress
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunConfig extends DunObject
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
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
	 * @since		1.0.0
	 */
	public function load()
	{
		// Grab user defined constants
		$constants	=	get_defined_constants( true );
		$constants	=	$constants['user'];
		
		foreach ( $constants as $key => $value ) {
			
			if ( strpos( $key, 'WP_' ) === 0 ) {
				$this->set( $key, $value );
			}
		}
		
		$db		=	dunloader( 'database', true );
		$db->setQuery( "SELECT `option_name` as 'name', `option_value` as 'value' FROM #__options WHERE `autoload` = " . $db->Quote( 'yes' ) );
		
		foreach ( $db->loadObjectList()  as $option ) {
			$this->set( $option->name, $option->value );
		}
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
		return;
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
		if ( empty( $item ) ) return;
		$this->$item = $value;
	}
}