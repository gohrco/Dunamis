<?php
/**
 * @projectName@
 * 
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.0.0
 * 
 * @desc       This file is the root file loaded by WHMCS upon selection of the "WHMCS Themer" addon
 * 
 */

/*-- Security Protocols --*/
if (!defined("WHMCS")) die("This file cannot be accessed directly");
/*-- Security Protocols --*/

/*-- Dunamis Inclusion --*/
$path	= dirname( dirname( dirname( dirname(__FILE__) ) ) ) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'dunamis.php';
if ( file_exists( $path ) ) include_once( $path );
/*-- Dunamis Inclusion --*/

/**
 * Configuration function called by WHMCS
 * 
 * @return An array of configuration variables
 * @since  1.0.0
 */
function dunamis_config()
{
	if (! function_exists( 'dunmodule' ) ) return array( 'name' => 'Dunamis Framework for WHMCS', 'description' => 'The Dunamis Framework was not detected!  Be sure it is installed fully!', 'version' => "@fileVers@" );
	return dunmodule( 'dunamis' )->getAdminConfig();
}


/**
 * Activation function called by WHMCS
 * 
 * @since  1.0.0
 */
function dunamis_activate()
{
	if (! function_exists( 'dunmodule' ) ) return;
}


/**
 * Deactivation function called by WHMCS
 * 
 * @since  1.0.0
 */
function dunamis_deactivate()
{
	if (! function_exists( 'dunmodule' ) ) return;
}


/**
 * Upgrade function called by WHMCS
 * @param  array		Contains the variables set in the configuration function
 * 
 * @since  1.0.0
 */
function dunamis_upgrade($vars)
{
	
	if (! function_exists( 'dunloader' ) ) return;
	$db	= dunloader( 'database', true );
	
	// This is the originally installed version
	if ( isset( $vars['version'] ) ) {
		$version = $vars['version'];
	}
	else
		// But this is what is found in 441 (not that we support it)
		if ( isset( $vars['themer']['version'] ) ) {
		$version = $vars['themer']['version'];
	}
	
	$thisvers	= "@fileVers@";
	
	while( $thisvers > $version ) {
		$filename	= 'sql' . DIRECTORY_SEPARATOR . 'upgrade-' . $version . '.sql';
		if (! file_exists( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $filename ) ) {
			$thisvers = $version;
			break;
		}
	
		$db->handleFile( $filename, 'themer' );
		$db->setQuery( "SELECT `value` FROM `tbladdonmodules` WHERE `module` = 'dunamis' AND `setting` = 'version'" );
		$version = $db->loadResult();
	}
}


/**
 * Output function called by WHMCS
 * @param  array		Contains the variables set in the configuration function
 * 
 * @since 1.0.0
 */
function dunamis_output($vars)
{	
	if (! function_exists( 'dunmodule' ) ) return;
	echo dunmodule( 'dunamis' )->renderAdminOutput();
}


/**
 * Function to generate sidebar menu called by WHMCS
 * @param  array		Contains the variables set in the configuration function
 * 
 * @since  1.0.0
 */
function dunamis_sidebar($vars)
{
	
}



?>