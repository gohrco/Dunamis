<?php defined('DUNAMIS') OR exit('No direct script access allowed');


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
			$config = dunloader( 'config', true );
			$version	= $config->get( 'Version' );
			define( 'DUN_ENV_VERSION', $version );
		}
	}
}


function get_errorsetting_whmcs( $checkfor = 'ErrorLevel' )
{
	$db = dunloader( 'database', true );
	
	switch( $checkfor ) :
	case 'ErrorLevel' :
		$db->setQuery( "SELECT `value` FROM tbladdonmodules WHERE `module` = 'dunamis' AND `setting` = 'ErrorLevel'" );
		$result = $db->loadObject();
		
		if (! $result ) return 'ERROR';
		else return strtoupper( $result->value );
		break;
	case 'DebugErrors' :
		$db->setQuery( "SELECT `value` FROM tbladdonmodules WHERE `module` = 'dunamis' AND `setting` = 'DebugErrors'" );
		$result = $db->loadObject();
		
		if (! $result ) return false;
		else if ( $result->value == 'Yes' ) return true;
		else return false;
		
		break;
	endswitch;
	
	
	
	
}


/**
 * Function to see if the Dunamis framework is enabled on WHMCS
 * @version		@fileVers@
 * 
 * @return		boolean
 * @since		1.0.2
 */
function is_enabled_on_whmcs()
{
	$db = dunloader( 'database', true );
	$db->setQuery( "SELECT * FROM tbladdonmodules WHERE `module` = 'dunamis'" );
	$results = $db->loadObjectList();
	
	// Assume if we have the module in the database it must be enabled
	foreach ( $results as $item ) {
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
	$parts	= explode( DIRECTORY_SEPARATOR, $path );
	
	if ( end( $parts ) == 'includes' ) {
		// For now we will assume we are in WHMCS (we must find more specific means of testing)
		return true;
	}
	
	return false;
}