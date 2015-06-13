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
	 * Method to add a database query to 
	 * @access		public
	 * @version		@fileVers@
	 * @param unknown $q
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function addQuery( $q )
	{
		if (! self :: $initialized ) $this->init();
		if (! self :: isEnabled() ) return;
		if (! class_exists( '\Tracy\Debugger' ) ) return;
		
		\Tracy\Debugger :: getBar()->getPanel( 'Tracy\QueriesBarPanel' )->data[] = array( 'dump' => $q );
	}
	
	
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
		// Lets initialized
		$tpath	=	dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'tracy' . DIRECTORY_SEPARATOR;
		
		require_once $tpath . 'IBarPanel.php';
		require_once $tpath . 'Bar.php';
		require_once $tpath . 'BlueScreen.php';
		require_once $tpath . 'DefaultBarPanel.php';
		require_once $tpath . 'Dumper.php';
		require_once $tpath . 'FireLogger.php';
		require_once $tpath . 'Helpers.php';
		require_once $tpath . 'Logger.php';
		require_once $tpath . 'Debugger.php';
		require_once $tpath . 'OutputDebugger.php';
		require_once $tpath . 'shortcuts.php';
		require_once $tpath . 'Queries.php';
		require_once $tpath . 'Api.php';
		
		// Check to see if we are enabled or not
		if (! self :: isEnabled() ) return;
		if ( self :: $initialized ) return;
		
		$serverName		=	isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "";
		$productionMode	=	php_sapi_name() === 'cli' || ( stripos($serverName, '.local' ) === false && stripos( $serverName, 'localhost' ) === false );
		
		// Permit custom location of logs
		$logpath = DUN_ENV_PATH . 'tmp' . DIRECTORY_SEPARATOR;
		
		$phpeval = <<< TXT
\Tracy\Debugger :: \$strictMode = false;
\Tracy\Debugger :: \$scream = false;
\Tracy\Debugger :: \$onFatalError = "\UnknownException::setFatalErrorHandler";
\Tracy\Debugger :: enable( \$productionMode, \$logpath );
\Tracy\Debugger :: getBar()->addPanel( new \Tracy\QueriesBarPanel );
\Tracy\Debugger :: getBar()->addPanel( new \Tracy\ApiBarPanel );
TXT;
		eval( $phpeval );
		
		self :: $initialized = true;
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
			self :: $isEnabled = get_errorsetting_joomla( 'DebugErrors' );
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