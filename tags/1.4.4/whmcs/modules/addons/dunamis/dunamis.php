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
	if (! function_exists( 'dunmodule' ) ) {
		return defaultdunamis_adminConfig( 'dunamis' );
	}
	
	$module		=	dunmodule( 'dunamis' );
	
	// Test to ensure it is found
	if (! is_object( $module ) ) {
		return defaultdunamis_adminConfig( 'module' );
	}
	
	if (! function_exists( 'dunmodule' ) ) return array( 'name' => 'Dunamis Framework for WHMCS', 'description' => 'The Dunamis Framework was not detected!  Be sure it is installed fully!', 'version' => "@fileVers@" );
	return $module->getAdminConfig();
}


/**
 * Activation function called by WHMCS
 * 
 * @since  1.0.0
 */
function dunamis_activate()
{
	if (! function_exists( 'dunloader' ) ) return;
	$install = dunmodule( 'dunamis.install' );
	$install->activate();
}


/**
 * Deactivation function called by WHMCS
 * 
 * @since  1.0.0
 */
function dunamis_deactivate()
{
	if (! function_exists( 'dunloader' ) ) return;
	$install = dunmodule( 'dunamis.install' );
	$install->deactivate();
}


/**
 * Upgrade function called by WHMCS
 * @param  array		Contains the variables set in the configuration function
 * 
 * @since  1.0.0
 */
function dunamis_upgrade($vars)
{
	// Ensure backwards compatible to v4.41
	// Bug in WHMCS dox state to use vars['version']
	if ( isset( $vars['version'] ) ) {
		$version = $vars['version'];
	}
	else
	// But this is what is found in 441
	if ( isset( $vars['dunamis']['version'] ) ) {
		$version = $vars['dunamis']['version'];
	}
	
	// We must handle legacy upgrades now
	if ( version_compare( $version, '1.4.0', 'l' ) ) {
		$install = dunmodule( 'dunamis.install' );
		$install->legacy();
		return;
	}
	
	$thisvers	= "@fileVers@";
	
	while( $thisvers > $version ) {
		$filename	= 'sql' . DIRECTORY_SEPARATOR . 'upgrade-' . $version . '.sql';
		if (! file_exists( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $filename ) ) {
			$thisvers = $version;
			break;
		}
	
		$db->handleFile( $filename, 'integrator' );
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



/**
 * Function to return a generic error message in the Addon Modules area in the event of a problem with Dunamis or the module
 * @version		@fileVers@ ( $Id$ )
 * @param		string		- $error: the nature of the error
 *
 * @return		array
 * @since		2.5.0
 */
function defaultdunamis_adminConfig( $error = 'dunamis' )
{
	switch ( $error ) :
	case 'dunamis' :
		$message = 'The Dunamis Framework was not detected!  Be sure it is installed fully before attempting to activate this module!';
	break;
	case 'module' :
		$message = 'Dunamis was unable to locate the module `dunamis`.  Please check to ensure you don\'t have any folders in your root directory called `dunamis` or any other modules elsewhere in WHMCS that are named `dunamis`.';
		break;
		endswitch;

		return array(
				'name'			=>	'Dunamis',
				'description'	=>	$message,
				'version'		=>	"@fileVers@"
		);
}
?>