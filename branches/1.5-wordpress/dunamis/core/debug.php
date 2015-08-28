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
 * Dunamis Core Debug File
 * @desc		This is the core Debug handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunDebug extends DunObject
{
	static $initialized = false;
	protected static $instance	=	null;
	protected static $isEnabled	=	null;
	
	
	/**
	 * Method to add a database query to
	 * @access		public
	 * @version		@fileVers@
	 * @param unknown $q
	 *
	 * @return		void
	 * @since		1.4.0
	 */
	public function addApi( $data = array() )
	{
		if (! self :: isInitialized() ) $this->init();
		if (! self :: isEnabled() ) return;
		if (! class_exists( '\Tracy\Debugger' ) ) return;
		\Tracy\Debugger :: getBar()->getPanel( 'Tracy\ApiBarPanel' )->addData( $data );
	}
	
	
	/**
	 * Method to add a database query to our stack
	 * @access		public
	 * @version		@fileVers@
	 * @param		string
	 *
	 * @since		1.4.0
	 */
	public function addQuery( $q )
	{
		if (! self :: isInitialized() ) $this->init();
		if (! self :: isEnabled() ) return;
		if (! class_exists( '\Tracy\Debugger' ) ) return;
		\Tracy\Debugger :: getBar()->getPanel( 'Tracy\QueriesBarPanel' )->data[] = array( 'dump' => $q );
	}
	
	
	/**
	 * Method to log an error message
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @version		1.5.0		- Revamp for Tracy
	 * @param		string		- $msg: what we want to log
	 *
	 * @since		1.0.11
	 */
	public function error( $msg )
	{
		if (! self :: isInitialized() ) $this->init();
		if (! self :: isEnabled() ) return;
		if (! class_exists( '\Tracy\Debugger' ) ) return;
		
		$calledby	=	debug_backtrace(0);
		$calledby	=	(object) array_shift( $calledby );
		
		\Tracy\Debugger :: getBar()->getPanel( 'Tracy\Debugger:errors' )->addData( $calledby->file, $calledby->line, $msg );
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.4.0
	 */
	public static function getInstance( $options = array() )
	{
		if (! is_object( self :: $instance ) ) {
				
			$classname	=	'DunDebug';
				
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunDebug';
			}
			
			if ( class_exists( $classname ) && defined( 'DUN_ENV' ) ) {
				self :: $instance	= new $classname( $options );
			}
			else {
				self :: $instance	= new self( $options );
			}
		}
	
		return self :: $instance;
	}
	
	
	/**
	 * Method to open a group
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $msg: what we want to call the group
	 * @param		array		- $options: if we want to spec options on the group
	 * 
	 * @since		1.0.11
	 */
	public static function group( $msg, $options = array() )
	{
		if (! self :: $isEnabled ) return;
		self :: $instance->group( t( $msg ), $options );
	}
	
	
	/**
	 * Method to end a group
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @since		1.0.11
	 */
	public static function groupEnd()
	{
		if (! self :: $isEnabled ) return;
		self :: $instance->groupEnd();
	}
	
	
	/**
	 * Method to log an info message
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $msg: what we want to log
	 *
	 * @since		1.0.11
	 */
	public static function info( $msg, $label = null, $options = array() )
	{
		if (! self :: $isEnabled ) return;
		self :: $instance->info( t( $msg ), $label, $options  );
	}
	
	
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
		if ( $path == null ) return;
		if ( $logpath == null ) return;
		
		require_once $path . 'IBarPanel.php';
		require_once $path . 'Bar.php';
		require_once $path . 'BlueScreen.php';
		require_once $path . 'DefaultBarPanel.php';
		require_once $path . 'Dumper.php';
		require_once $path . 'FireLogger.php';
		require_once $path . 'Helpers.php';
		require_once $path . 'Logger.php';
		require_once $path . 'Debugger.php';
		require_once $path . 'OutputDebugger.php';
		require_once $path . 'shortcuts.php';
		require_once $path . 'Queries.php';
		require_once $path . 'Api.php';
		
		// Check to see if we are enabled or not
		if (! self :: isEnabled() ) return;
		if ( self :: isInitialized() ) return;
		
		$serverName		=	isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "";
		$productionMode =	php_sapi_name() === 'cli';
		
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
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.11
	 */
	protected static function isEnabled()
	{
		if ( self :: $isEnabled === null ) {
			$fnxn	=	'get_errorsetting_' . strtolower( DUN_ENV );
			$state	=	call_user_func( $fnxn );
			self :: setEnabled( $state );
		}
		
		return self :: $isEnabled;
	}
	
	
	/**
	 * Method to determine if our debugger is initialized
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @return		boolean
	 * @since		1.4.0
	 */
	protected static function isInitialized()
	{
		return self :: $initialized == true;
	}
	
	
	/**
	 * Method to log a message
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $msg: what we want to log
	 *
	 * @since		1.0.11
	 */
	public static function log( $msg, $label = null, $options = array() )
	{
		if (! self :: $isEnabled ) return;
		self :: $instance->log( t( $msg ), $label, $options );
	}
	
	
	/**
	 * Method to enable the debug
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		boolean
	 *
	 * @since		1.4.0
	 */
	public static function setEnabled( $state = false )
	{
		self :: $isEnabled = $state;
	}
	
	
	/**
	 * Dumps a variable to our debug bar
	 * @access		public
	 * @version		@fileVers@
	 * @param		mixed
	 * @param		string
	 * 
	 * @since		1.4.0
	 */
	public function variable( $var, $msg = null )
	{
		if (! self :: isInitialized() ) $this->init();
		if (! self :: isEnabled() ) return;
		if (! class_exists( '\Tracy\Debugger' ) ) return;
		\Tracy\Debugger :: barDump( $var, $msg );
	}
	
	
	/**
	 * Method to log a warning message
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $msg: what we want to log
	 *
	 * @since		1.0.11
	 */
	public static function warn( $msg, $label = null, $options = array() )
	{
		if (! self :: $isEnabled ) return;
		self :: $instance->warn( t( $msg ), $label, $options  );
	}
}