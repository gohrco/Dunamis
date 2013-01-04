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
	}
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