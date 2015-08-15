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
 * Dunamis Environment class for Wordpress
 * @desc		This is the environment file for determining if we are in the Wordpress environment
 * @package		Dunamis
 * @subpackage	Wordpress
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunEnvironment extends DunEnvironment
{
	
	/**
	 * Method to define constants for the operating environment
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.5.0
	 * @see			DunEnvironment :: defines()
	 */
	public function defines()
	{
		parent :: defines();
		
		// DUN_ENV:  system environment
		if (! defined( 'DUN_ENV' ) ) {
			define( 'DUN_ENV', 'WORDPRESS' );
		}
		
		// DUN_ENV_PATH:  path to the system environment folder
		if (! defined( 'DUN_ENV_PATH' ) ) {
			define( 'DUN_ENV_PATH', ABSPATH );
		}
		
		dunimport( 'helpers', true, true );
		
		// DUN_ENV_VERSION:  we need to be able to test version
		if (! defined( 'DUN_ENV_VERSION' ) ) {
			$version	=	get_bloginfo( 'version' );
			define( 'DUN_ENV_VERSION', $version );
		}
	}
}


/**
 * Function to get a steting from Wordpress database table
 * @access		public
 * @version		@fileVers@ ( $Id$ )
 * @param		string		- $checkfor: what we are checking for (deprecated / unusued)
 *
 * @return		boolean
 * @since		1.5.0
 */
function get_errorsetting_wordpress( $checkfor = 'ErrorLevel' )
{
	$debug	=	get_option( 'dunamis_debug' );
	return (bool) $debug;
}


/**
 * Function to see if the Dunamis framework is enabled on Wordpress
 * @version		@fileVers@
 * 
 * @return		boolean
 * @since		1.5.0
 */
function is_enabled_on_wordpress()
{
	$var	=	get_option( 'active_plugins' );
	if (! is_array( $var ) ) return false;
	
	foreach ( $var as $v ) {
		if ( $v == 'dunamis.php' ) return true;
	}
	
	return false;
}


/**
 * Function to see if the environment matches that of Wordpress
 * @version		@fileVers@
 * 
 * @return		boolean
 * @since		1.5.0
 */
function is_this_wordpress()
{
	// These are just minPHP stanards, we need to find Blesta specific items to test for
	if ( defined( 'ABSPATH' ) && defined( 'WPINC' ) ) {
		return true;
	}
	
	return false;
}