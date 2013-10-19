<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Dunamis Core Document File
 * This is the core Document handler of the Dunamis Framework
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

// define('DUNAMIS', true);
// include 'object.php';

/**
 * DunDocument Object
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.0
 */

class DunEnvironment extends DunObject
{
	public function defines()
	{
		// DUN_PATH:  /dunamis
		if (! defined( 'DUN_PATH' ) ) {
			define( 'DUN_PATH', dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR );
		}
		
		// DUN_CORE:  /dunamis/core
		if (! defined( 'DUN_CORE' ) ) {
			define( 'DUN_CORE', DUN_PATH . 'core' . DIRECTORY_SEPARATOR );
		}
		
		// DUN_OS_ISWIN: [t|F]
		if (! defined( 'DUN_OS_ISWIN' ) ) {
			define( 'DUN_OS_ISWIN', ( strtoupper( substr( PHP_OS, 0, 3 ) ) == 'WIN' ) );
		}
		
		// DUN_SYS_ISMAC: [t|F]
		if (! defined( 'DUN_SYS_ISMAC' ) ) {
			define( 'DUN_SYS_ISMAC', ( strtoupper( substr(PHP_OS, 0, 3 ) ) === 'MAC' ) );
		}
	}
}