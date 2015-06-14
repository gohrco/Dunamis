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
 * Dunamis Debug handler for Joomla
 * @desc		This is the debug handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JoomlaDunDebug extends DunDebug
{
	
	static $initialized = false;
	
	/**
	 * Method to initialize the debug object
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string
	 * @param		string
	 *
	 * @since		1.0.11
	 */
	public static function init( $path = null, $logpath = null )
	{
		// Lets set our paths
		if ( $path == null ) {
			$path = dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'tracy' . DIRECTORY_SEPARATOR;
		}
		
		if ( $logpath == null ) {
			$logpath = DUN_ENV_PATH . 'tmp';
		}
		
		parent :: init( $path, $logpath );
	}
	
	
	/**
	 * Method to check if debugging is enabled
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.11
	 */
	protected static function isEnabled()
	{
		if ( self :: $isEnabled === null ) {
			$state	=	get_errorsetting_joomla( 'DebugErrors' );
			self :: setEnabled( $state );
		}
		
		return (bool) self :: $isEnabled;
	}
	
	
	/**
	 * Method for returning a debug response via the API
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.3.3
	 */
	public function renderforApi()
	{
		if (! class_exists( '\Tracy\Debugger' ) ) return;
		return \Tracy\Debugger :: getBar()->renderforApi();
	}
}