<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Dunamis Core Debug File
 * This is the core Debug handler of the Dunamis Framework
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */


/**
 * Dunamis Debug class handler
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.11
 */
abstract class DunDebug extends DunObject
{
	protected static $instance	=	null;
	protected static $isEnabled	=	null;
	
	/**
	 * Method to log an error message
	 * @access		protected
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $msg: what we want to log
	 *
	 * @since		1.0.11
	 */
	public static function error( $msg, $label = null, $options = array() )
	{
		if (! self :: $isEnabled ) return;
		self :: $instance->error( t( $msg ), $label, $options  );
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
	 *
	 * @since		1.0.11
	 */
	public static function init()
	{
		if (! is_object( self :: $instance ) ) {
			$ds		=	DIRECTORY_SEPARATOR;
			$path	=	dirname(__FILE__) . DIRECTORY_SEPARATOR
					.	'firebug' . DIRECTORY_SEPARATOR
					.	'FirePHP.class.php';
			@require_once( $path );
			
			self :: $instance = FirePHP :: getInstance( true );
		}
		
		self :: group( 'Dunamis Debugging Initialized' );
		self :: log( 'Firebug Initialized' );
		self :: log( 'Ensure if this is a production environment that the debugging is disabled when completed.' );
		self :: groupEnd();
	}
	
	
	/**
	 * Method to check if debugging is enabled
	 * @access		protected
	 * @abstract
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.11
	 */
	protected static function isEnabled() {}
	
	
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