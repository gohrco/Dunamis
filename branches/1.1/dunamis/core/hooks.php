<?php defined('DUNAMIS') OR exit('No direct script access allowed');


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
	public static function getInstance()
	{
		if (! is_object( self :: $instance ) ) {
			
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunHooks';
				self :: $instance	= new $classname();
			}
			else {
				self :: $instance = new self();
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