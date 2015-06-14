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
 * Dunamis Debug handler for WHMCS
 * @desc		This is the debug handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunDebug extends DunDebug
{
	/**
	 * Variable to indicate we have initialized already
	 * @static
	 * @var			boolean
	 * @since		1.3.3
	 */
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
			$logpath = DUN_ENV_PATH . 'modules' . DIRECTORY_SEPARATOR . 'addons' . DIRECTORY_SEPARATOR . 'dunamis' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR;
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
			$state	=	get_errorsetting_whmcs( 'DebugErrors' );
			self :: setEnabled( $state );
		}
		
		return (bool) parent :: isEnabled();
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
		if (! self :: isInitialized() ) $this->init();
		if (! self :: isEnabled() ) return;
		if (! class_exists( '\Tracy\Debugger' ) ) return;
		return \Tracy\Debugger :: getBar()->renderforApi();
	}
}


class WDD extends WhmcsDunDebug {}