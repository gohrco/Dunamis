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
 * Dunamis Base Environment File
 * @desc		This is the core environment handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
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


/**
 * Dunamis Environment class for Joomla
 * @desc		This is used by Dunamis to determine the environment and to set common environment variables
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class CoreDunEnvironment extends DunEnvironment
{

	/**
	 * Method to define constants for the operating environment
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		2.0.0
	 * @see			DunEnvironment :: defines()
	 */
	public function defines()
	{
		parent::defines();

		// DUN_ENV:  system environment
		if (! defined( 'DUN_ENV' ) ) {
			define( 'DUN_ENV', 'CORE' );
		}

		// DUN_ENV_PATH:  path to the system environment folder
		if (! defined( 'DUN_ENV_PATH' ) ) {
			define( 'DUN_ENV_PATH', dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR );
		}

		dunimport( 'helpers', true, true );
		
		if (! defined( 'DUN_ENV_PATH' ) ) {
			define( 'DUN_ENV_VERSION', '@fileVers@' );
		}
	}
}


/**
 * Function to get a steting from WHMCS database table
 * @access		public
 * @version		@fileVers@ ( $Id$ )
 * @param		string		- $checkfor: what we are checking for
 *
 * @return		boolean
 * @since		2.0.0
 */
function get_errorsetting_core( $checkfor = 'ErrorLevel' )
{
	return true;
}


/**
 * Function to see if the Dunamis framework is enabled on core
 * @version		@fileVers@
 *
 * @return		boolean
 * @since		2.0.0
 */
function is_enabled_on_core()
{
	return true;
}


/**
 * Function to see if the environment matches that of the core
 * @version		@fileVers@
 *
 * @return		boolean
 * @since		2.0.0
 */
function is_this_core()
{
	$path	=	dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR;
	foreach ( array( 'blesta', 'joomla', 'dunamis', 'whmcs', 'tests' ) as $folder ) {
		if (! is_dir( $path . $folder ) ) {
			return false;
		}
	}
	
	return true;
}