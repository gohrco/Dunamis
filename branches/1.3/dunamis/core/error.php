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

define( 'DUN_NOTICE',	1 );
define( 'DUN_WARNING',	2 );
define( 'DUN_ERROR',	4 );

define( 'DUN_UNNOTICE',		8 );
define( 'DUN_UNWARNING',	16 );
define( 'DUN_UNERROR',		32 );

/**
 * Dunamis Core Error File
 * @desc		This is the core error handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunError extends DunObject
{
	static protected $_loaded	= false;
	static protected $_stack	= array();
	
	
	static public function attachError( $error )
	{
		if (! self :: $_loaded ) {
			self :: setStyle();
			self :: $_loaded = true;
		}
		
		self :: $_stack[] = $error;
	}
	
	
	static public function checkLevels( $level )
	{
		$data	= array();
		
		switch( $level ) {
			case 'NOTICE':
				$data[]	= DUN_NOTICE;
				$data[] = DUN_UNNOTICE;
			case 'WARNING':
				$data[] = DUN_WARNING;
				$data[] = DUN_UNWARNING;
			case 'ERROR':
				$data[] = DUN_ERROR;
				$data[] = DUN_UNERROR;
		}
		
		return $data;
	}
	
	
	static public function displayErrors( $level = 'ERROR' )
	{
		return;
	}
	
	
	static public function setError()
	{
		$vars	= func_get_args();
		
		if ( in_array( $vars[0], array( E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR ) ) ) {
			$code = DUN_UNERROR;
		}
		else if ( in_array( $vars[0], array( E_WARNING, E_CORE_WARNING, E_COMPILE_WARNING, E_USER_WARNING ) ) ) {
			$code = DUN_UNWARNING;
		}
		else {
			$code = DUN_UNNOTICE;
		}
		
		$error	= array( 'code' => $code, 'msg' => $vars[1], 'path' => $vars[2], 'line' => $vars[3] );
		self :: attachError( $error );
	}
	
	
	static public function setException()
	{
		$vars	= func_get_args();
		$error	= array( 'code' => $vars[0], 'msg' => $vars[1], 'path' => $vars[2], 'line' => $vars[3] );
		self :: $_stack[] = $error;
	}
	
	
	static public function setStyle()
	{
		$class	= ucfirst(strtolower( DUN_ENV ) ) . 'DunError';
		if ( class_exists( $class ) ) call_user_func ("{$class}::setStyle" );
	}
	
	
	static public function translate( $code = 1 )
	{
		switch ( $code ) :
		case DUN_UNERROR:
			return 'Uncaught error';
		case DUN_UNNOTICE:
			return 'Uncaught notice';
		case DUN_UNWARNING:
			return 'Uncaught warning';
		case DUN_NOTICE:
			return 'Notice';
		case DUN_WARNING:
			return 'Warning';
		case DUN_ERROR:
			return 'Error';
		endswitch;
		return $code;
	}
}