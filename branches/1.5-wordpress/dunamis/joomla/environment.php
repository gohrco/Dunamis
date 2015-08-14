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

defined( 'DUNAMIS' ) OR exit('No direct script access allowed');

/**
 * Dunamis Environment class for Joomla
 * @desc		This is used by Dunamis to determine the environment and to set common environment variables 
 * @package		Dunamis
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JoomlaDunEnvironment extends DunEnvironment
{
	
	/**
	 * Method to define constants for the operating environment
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.1.0
	 * @see			DunEnvironment :: defines()
	 */
	public function defines()
	{
		parent::defines();
		
		// DUN_ENV:  system environment
		if (! defined( 'DUN_ENV' ) ) {
			define( 'DUN_ENV', 'JOOMLA' );
		}
		
		// DUN_ENV_PATH:  path to the system environment folder
		if (! defined( 'DUN_ENV_PATH' ) ) {
			define( 'DUN_ENV_PATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . DIRECTORY_SEPARATOR );
		}
		
		dunimport( 'helpers', true, true );
		
		// DUN_ENV_VERSION:  we need to be able to test version
		if (! defined( 'DUN_ENV_VERSION' ) ) {
			
			$path	=	DUN_ENV_PATH . 'libraries' . DIRECTORY_SEPARATOR;
			
			// ---- BEGIN DUN-9
			//		Installation of Dunamis Library causes fatal error WSOD
			// We must test for Joomla version
			if (! class_exists( 'JVersion' ) ) {
				if ( file_exists( $filename = $path . 'joomla' . DIRECTORY_SEPARATOR . 'version.php' ) ) {
					@include_once( $filename );
				}
				else {
					$filename	=	$path . 'cms' . DIRECTORY_SEPARATOR . 'version' . DIRECTORY_SEPARATOR . 'version.php';
					@include_once( $filename );
				}
			}
			// ---- END DUN-9
			
			if ( class_exists( 'JVersion' ) ) {
				$version = new JVersion();
				define( 'DUN_ENV_VERSION', $version->getShortVersion() );
			}
		}
	}
}


/**
 * Function to set error reporting based on configuration
 * @access		public
 * @version		@fileVers@
 * @param		string		- $checkfor: what we are looking for
 *
 * @return		void|string|boolean
 * @since		1.1.0
 */
function get_errorsetting_joomla( $checkfor = 'ErrorLevel' )
{
	$params	=	(object) JComponentHelper :: getParams( 'com_dunamis' )->toArray();
	
	return ( isset( $params->debug ) ? $params->debug == 'Yes' : false );
}


/**
 * Function to see if the Dunamis framework is enabled on Joomla
 * @TODO:  Implement enable check for Joomla 1.5
 * @version		@fileVers@
 * 
 * @return		boolean
 * @since		1.1.0
 */
function is_enabled_on_joomla()
{
	if ( version_compare( DUN_ENV_VERSION, '1.6.0', 'ge' ) ) {
		$db = dunloader( 'database', true );
		$db->setQuery( "SELECT `enabled` FROM `#__extensions` WHERE `type` = 'library' AND `element` = 'lib_dunamis'" );
		$result	=	$db->loadResult();
		
		return (bool) $result;
	}
	
	// If we are here it's 1.5 and we have to figure this out
	return true;
}


/**
 * Function to see if the environment matches that of Joomla
 * @version		@fileVers@
 * 
 * @return		boolean
 * @since		1.1.0
 */
function is_this_joomla()
{
	$path	= dirname( __FILE__ );
	
	// If we are in the includes directory AND the WHMCS constant is defined then lets assume we are in there
	if ( strpos($path, 'libraries' ) !== false && defined( '_JEXEC' ) ) {
		return true;
	}
	
	return false;
}