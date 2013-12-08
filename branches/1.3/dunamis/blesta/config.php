<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */


/**
 * Dunamis Configuration class for Blesta
 * @desc		This grabs configuration settings from Blesta for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class BlestaDunConfig extends DunObject
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.3.0
	 */
	public function __construct( $options = array() )
	{
		
	}
	
	
	/**
	 * Getter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being sought
	 * 
	 * @return		mixed value of setting or false
	 * @since		1.3.0
	 */
	public function get( $item )
	{
		$item	=	Configure :: get( $item );
		
		if ( $item != null ) {
			return $item;
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
	 * @since		1.3.0
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
		return Configure :: exists( $item );
	} 
	
	
	/**
	 * Setter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being set
	 * @param		mixed		- $value: the value to set
	 * 
	 * @since		1.3.0
	 */
	public function set( $item, $value )
	{
		Configure :: set ( $item, $value );
	}
}