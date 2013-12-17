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
 * Dunamis Core Hooks File
 * @desc		This is the core hooks handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunHooks extends DunObject
{
	
	/**
	 * Stores the extension calling us up
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $extension = null;
	
	protected static $instance = null;
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		
	}
	
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		if (! is_object( self :: $instance ) ) {
			
			$classname	=	'DunLanguage';
			
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunHooks';
			}
			
			if ( class_exists( $classname ) && defined( 'DUN_ENV' ) ) {
				self :: $instance	= new $classname( $options );
			}
			else {
				self :: $instance	= new self( $options );
			}
		}
	
		return self :: $instance ;
	}
	
	
	/**
	 * Gets the extension from the object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function getExtension()
	{
		return $this->extension;
	}
	
	
	/**
	 * Sets the extension name in place
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: the name of the extension
	 * 
	 * @since		1.0.0
	 * @param unknown_type $name
	 */
	public function setExtension( $name = null )
	{
		$this->extension = $name;
	}
}