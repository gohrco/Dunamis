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

// ---- BEGIN DUN-8
//		Including the WHMCS environment first in Joomla causes fatal error
$filename	=	dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'dbfunctions.php';

if ( file_exists( $filename ) ) {
	require_once $filename;
}
// ---- END DUN-8


/**
 * Dunamis Environment class for WHMCS
 * @desc		This is the environment file for determining if we are in the WHMCS environment
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunEnvironment extends DunEnvironment
{
	
	/**
	 * Method to define constants for the operating environment
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 * @see			DunEnvironment :: defines()
	 */
	public function defines()
	{
		parent::defines();
		
		// DUN_ENV:  system environment
		if (! defined( 'DUN_ENV' ) ) {
			define( 'DUN_ENV', 'WHMCS' );
		}
		
		// DUN_ENV_PATH:  path to the system environment folder
		if (! defined( 'DUN_ENV_PATH' ) ) {
			define( 'DUN_ENV_PATH', dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . DIRECTORY_SEPARATOR );
		}
		
		dunimport( 'helpers', true, true );
		
		// DUN_ENV_VERSION:  we need to be able to test version
		if (! defined( 'DUN_ENV_VERSION' ) ) {
			$config = dunloader( 'config', true, array( 'database' => false, 'session' => true ) );
			$version	= $config->get( 'Version' );
			define( 'DUN_ENV_VERSION', $version );
		}
	}
}


/**
 * Function to get a steting from WHMCS database table
 * @access		public
 * @version		@fileVers@ ( $id$ )
 * @version		1.1.5		- August 2013: must rely on WHMCS database function as our DB handler breaks quote use (DUN-4)
 * @param		string		- $checkfor: what we are checking for
 *
 * @return		boolean
 * @since		1.0.2
 */
function get_errorsetting_whmcs( $checkfor = 'ErrorLevel' )
{
	switch( $checkfor ) :
	case 'ErrorLevel' :
		$result	=	select_query( 'tbladdonmodules', 'value', array( 'module' => 'dunamis', 'setting' => 'ErrorLevel' ) );
		$data	=	mysql_fetch_object( $result );
		
		if (! $data ) return 'ERROR';
		else return strtoupper( $data->value );
		break;
	case 'DebugErrors' :
		$result	=	select_query( 'tbladdonmodules', 'value', array( 'module' => 'dunamis', 'setting' => 'DebugErrors' ) );
		$data	=	mysql_fetch_object( $result );
		
		if (! $data ) return false;
		else if ( $data->value == 'Yes' ) return true;
		else return false;
		
		break;
	endswitch;
	
	
	
	
}


/**
 * Function to see if the Dunamis framework is enabled on WHMCS
 * @version		@fileVers@
 * @version		1.1.5		- August 2013: must rely on WHMCS database function as our DB handler breaks quote use (DUN-4)
 * 
 * @return		boolean
 * @since		1.0.2
 */
function is_enabled_on_whmcs()
{
	$result	= select_query( 'tbladdonmodules', '*', array( 'module' => 'dunamis' ) );
	$data	= mysql_fetch_array($result);
	
	foreach ( $data as $item ) {
		return true;
	}
	
	return false;
}


/**
 * Function to see if the environment matches that of WHMCS
 * @version		@fileVers@
 * 
 * @return		boolean
 * @since		1.0.0
 */
function is_this_whmcs()
{
	$path	= dirname( dirname( dirname( __FILE__ ) ) );
	
	// If we are in the includes directory AND the WHMCS constant is defined then lets assume we are in there
	if ( strpos($path, 'includes' ) !== false && defined( 'WHMCS' ) ) {
		return true;
	}
	
	return false;
}