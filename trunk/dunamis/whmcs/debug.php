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
	 * Method to initialize the debug object
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $name: the calling name
	 *
	 * @since		1.0.11
	 */
	public static function init()
	{
		// Check to see if we are enabled or not
		if (! self :: isEnabled() ) {
			return;
		}
		
		// Lets initialized
		$tpath	=	dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'tracy' . DIRECTORY_SEPARATOR;
		
		require $tpath . 'IBarPanel.php';
		require $tpath . 'Bar.php';
		require $tpath . 'BlueScreen.php';
		require $tpath . 'DefaultBarPanel.php';
		require $tpath . 'Dumper.php';
		require $tpath . 'FireLogger.php';
		require $tpath . 'Helpers.php';
		require $tpath . 'Logger.php';
		require $tpath . 'Debugger.php';
		require $tpath . 'OutputDebugger.php';
		require $tpath . 'shortcuts.php';
		require $tpath . 'Queries.php';
		
		$serverName		=	isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "";
		$productionMode	=	php_sapi_name() === 'cli' || ( stripos($serverName, '.local' ) === false && stripos( $serverName, 'localhost' ) === false );
		
		// Permit custom location of logs
		$logpath = DUN_ENV_PATH . 'logs';
		
		$phpeval = <<< TXT
\Tracy\Debugger :: \$strictMode = true;
\Tracy\Debugger :: \$scream = true;
\Tracy\Debugger :: \$onFatalError = "\UnknownException::setFatalErrorHandler";
\Tracy\Debugger :: enable( \$productionMode, \$logpath );
\Tracy\Debugger :: getBar()->addPanel( new \Tracy\QueriesBarPanel );
TXT;
		eval( $phpeval );
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
			self :: $isEnabled = get_errorsetting_whmcs( 'DebugErrors' );
		}
		
		return (bool) self :: $isEnabled;
	}
}


class WDD extends WhmcsDunDebug {}