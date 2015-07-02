<?php
/**
 * @package         @packageName@
 * @subpackage		WHMCS
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

defined('DUNAMIS') OR exit('No direct script access allowed');


/**
 * Function for checking compatibility with applications
 * @version		@fileVers@ ( $id )
 * @param		string		- $app: the application we are testing - for future expansion
 *
 * @return		boolean
 * @since		1.4.0
 */
if (! function_exists( 'check_compatible' ) ) {
function check_compatible( $app = 'dunamis' )
{
	switch ( $app ) :

	case 'dunamis'		:	return true;

	endswitch;
}
}


/**
 * Function for retrieving the base url
 * @version		@fileVers@
 * @since		1.0.0
 */
if (! function_exists( 'get_baseurl' ) )
{
	function get_baseurl( $location = 'client' )
	{
		// Let's get our System URL first
		$config	=	dunloader( 'config', true );
		$uri	=	DunUri :: getInstance( rtrim( $config->get( 'SystemURL' ), '/' ) . '/', true );
		
		// Check SSL on current URL
		$curi	=	DunUri :: getInstance( 'SERVER', true );
		$uri->setScheme( $curi->getScheme() );
		
		// -----------------------------------------------
		// First we clean up the uri
		// -----------------------------------------------
		// Kill query strings
		$uri->setQuery( null );
		
		// Kill the filename if set
		$path	= $uri->getPath();
		$parts	= explode( '/', $path );
		if ( strstr( end( $parts ), '.php' ) !== false ) {
			array_pop( $parts );
			$uri->setPath( implode( '/', $parts ) );
		}
		
		// See if we are in admin but requesting another location
		if ( is_admin() && $location != 'admin' ) {
			$path	= $uri->getPath();
			$parts	= explode( '/', $path );
				
			$parts	= array_reverse( $parts );
				
			if ( strstr( $parts[0], '.php' ) !== false ) {
				array_shift( $parts );
			}
				
			array_shift( $parts );
				
			$parts	= array_reverse( $parts );
			$path	= implode( '/', $parts );
				
			$uri->setPath( $path . '/' );
		}
		// If we are in admin and we are requesting the admin then we are there :)
		else if ( is_admin() && $location == 'admin' ) {
			if ( $uri->toString() == get_baseurl( 'client' ) ) {
				include dirname( dirname( dirname( __DIR__ ) ) ) . DIRECTORY_SEPARATOR . 'configuration.php';
				$adminfolder	=	( isset( $customadminpath ) ? $customadminpath : 'admin' );
				$uri->setPath( rtrim( $uri->getPath(), '/' ) . '/admin' );
			}
			return $uri->toString();
		}
		
		// -----------------------------------------------
		// Next switch based on location request
		// -----------------------------------------------
		switch ( $location ) {
			// We are looking for the front end location
			case 'client' :
				return $uri->toString();
				break;
			// We are looking for the admin location
			case 'admin' :
				break;
			// We are looking for the module location
			default :
				$type	= WhmcsDunModule :: locateModuleType( $location );
				
				switch ( $type ) {
					case 'reports' :
						$uri	= DunUri :: getInstance( WhmcsDunModule :: locateModuleUrl( $location ), true );
						$uri->setVar( 'report', $location );
						break;
					default :
						$path	= WhmcsDunModule :: locateModuleUrl( $location ) . $location . '/';
						$uri->setPath( rtrim( $uri->getPath(), '/' ) . $path );
				}
				
				return $uri->toString();
				break;
		}
	}
}


/**
 * Function for determining what executed file we are actually on
 * @version		@fileVers@
 * @since		1.0.5
 */
if (! function_exists( 'get_filename' ) )
{
	function get_filename()
	{
		$uri	=	DunUri :: getInstance( 'SERVER', true );
		$parts	=	explode( '/', $uri->getPath() );
		$file	=	str_replace( '.php', '', end( $parts ) );
		
		// If we dont have a file assume index
		if ( strlen( $file ) == 0 ) return 'index';
		else return $file;
	}
}


/**
 * Function for building a path given a foldername (can be name.next.dir)
 * @version		@fileVers@
 * @param		string		- $path: contains the subfolders in name.next.dir format ( '.' will return base )
 * @param		mixed		- $env: [f|T|string] specifies relative to...
 * 								false is relative to Dunamis root
 * 								true relative to environment
 * 								string is module name
 * @param		string		- $filename: if we want to append a filename we may
 * @return		string or false if built path / filepath doesn't exist 
 * @since		1.0.10
 */
if (! function_exists( 'get_path' ) )
{
	function get_path( $path = null, $env = true, $filename = null )
	{
		// If we pass no path then return environment path or Dunamis path if we request
		if ( $path == null ) {
			return ( $env ? DUN_ENV_PATH : DUN_PATH );
		}
		
		$path	=	str_replace( '.', DIRECTORY_SEPARATOR, $path );
		
		// Reset path
		if ( $path == DIRECTORY_SEPARATOR ) {
			$path = null;
		}
		
		// DUN variables
		if ( is_bool( $env ) ) {
			$path	=	( $env ? DUN_ENV_PATH : DUN_PATH ) . $path;
		}
		// Module name provided
		else {
			
			// Be sure our module is loaded
			if (! defined( 'DUN_MOD_' . strtoupper( $env ) ) ) {
				dunmodule( $env );
			}
			
			// Get the path
			$path = get_dunamis( $env )->getModulePath( $env, $path );
		}
		
		// If we don't need to append filename then return
		if (! $filename ){
			return ( is_dir( $path ) ? $path : false );
		}
		
		// Append filename
		$path	.=	DIRECTORY_SEPARATOR . $filename;
		
		return ( file_exists( $path ) ? $path : false );
	}
}

/**
 * Function for determining if we are in the admin area or not
 * @version		@fileVers@
 * @since		1.0.0
 */
if (! function_exists( 'is_admin' ) )
{
	function is_admin()
	{
		return ( defined( "CLIENTAREA" ) == true ? false : true );
	}
}


/**
 * Function for determining if we are in the api area or not
 * @version		@fileVers@
 * @since		1.0.0
 */
if (! function_exists( 'is_api' ) )
{
	function is_api()
	{
		// See if we are calling up the Dunamis API first
		if ( defined( "APIAREA" ) == true ) {
			return true;
		}
		
		if ( get_filename() != 'api' ) {
			return false;
		}
		
		// Can't know for sure without checking path
		$uri	=	DunUri :: getInstance( 'SERVER', true );
		$parts	=	explode( '/', $uri->getPath() );
		
		if ( in_array( 'includes', $parts ) && in_array( 'api.php', $parts ) ) {
			return true;
		}
		
		return false;
	}
}


/**
 * Function for determining if we are using SSL on this page or not
 * @version		@fileVers@
 * @since		1.1.0
 */
if (! function_exists( 'is_ssl' ) ) {
	function is_ssl()
	{
		$uri	=	DunUri  :: getInstance( 'SERVER', true );
		$scheme	=	$uri->getScheme();

		return $scheme == 'https';
	}
}


/**
 * Function for conveniently loading the bootstrap for module
 * @version		@fileVers@
 * @version		1.0.9		- March 2013: WHMCS 5.2 compatibility included; bootstrapSwitch added for toggleyn field
 * @since		1.0.1
 */
if (! function_exists( 'load_bootstrap' ) )
{
	function load_bootstrap( $module = null )
	{
		if ( $module == null ) return;
		
		$base	= rtrim( get_baseurl( 'client' ), '/' );
		$uri	= DunUri :: getInstance( $base, true );
		$uri->delVars();
		
		$doc = dunloader( 'document', true );
		
		$doc->addStyleSheet( $base . '/includes/dunamis/core/bootstrap/css/reset.php?m=' . urlencode( $module ) );			// Reset CSS
		$doc->addStyleSheet( $base . '/includes/dunamis/core/bootstrap/css/bootstrap.2.3.1.php?m=' . urlencode( $module ) );	// Our bootstrap
		$doc->addStyleSheet( $base . '/includes/dunamis/core/assets/css/bootstrapSwitch.php?m=' . urlencode( $module ) );
		
		// Older versions of WHMCS require newer jQuery
		$doc->makeCompatible( '5.2' );
		
		$doc->addScript( $base . '/includes/dunamis/core/bootstrap/js/bootstrap.min.js' );								// Our javascript
		$doc->addScript( $base . '/includes/dunamis/core/assets/js/bootstrapSwitch.js' );
	}
}


/**
 * Common method to load the google libraries and create a client
 * @version		@fileVers@
 * 
 * @return		Google Client object
 * @since		1.0.1
 */
if (! function_exists( 'load_google' ) )
{
	function load_google()
	{
		require_once( DUN_ENV_PATH . 'includes/dunamis/whmcs/googleapi/Google_Client.php' );
		require_once( DUN_ENV_PATH . 'includes/dunamis/whmcs/googleapi/contrib/Google_WebfontsService.php' );
			
		return new Google_Client();
	}
}


/**
 * Function to load the onscreen help overlay
 * @version		@fileVers@
 * 
 * @since		1.0.10
 */
if (! function_exists( 'load_onscreenhelp' ) )
{
	function load_onscreenhelp()
	{
		$base	= rtrim( get_baseurl( 'client' ), '/' );
		$uri	= DunUri :: getInstance( $base, true );
		$uri->delVars();
		
		$doc = dunloader( 'document', true );
		$doc->addStyleSheet( $base . '/includes/dunamis/core/assets/css/chardinjs.css' );
		$doc->addScript( $base . '/includes/dunamis/core/assets/js/chardinjs.js' );
	}
}


/**
 * Function to remove the filename from a URI object
 * @desc		Won't work if URL is being SEOd in WHMCS
 * @version		@fileVers@
 * @param		DunUri		- $uri: the uri object to alter
 * 
 * @return		DunUri object
 * @since		1.1.0
 */
if (! function_exists( 'remove_filename' ) )
{
	function remove_filename( $uri = null )
	{
		// Ensure we have a URI object
		if ( $uri == null || ! is_a( $uri, 'DunUri' ) ) {
			$uri	=	DunUri :: getInstance( 'SERVER', true );
		}
		
		$path	=	$uri->getPath();
		
		// Use the global variable /requesturl
		global $requesturl;
		$req	=	trim( $requesturl, '/' );
		$parts	=	explode( '?', $req );
		$req	=	array_shift( $parts );
		
		$parts	=	explode( '/', $path );
		foreach ( $parts as $i => $part ) {
			if ( $part != $req ) continue;
			unset ( $parts[$i] );
		}
		
		$uri->setPath( implode( '/', $parts ) );
		
		return $uri;
	}
}

/**
 * Function for outputing the WHMCS GLOBALS without the smarty tpl_vars, _LANG and _DEFAULTLANG to clutter up the results
 * @version		@fileVers@
 * 
 * @since		1.0.8
 */
if (! function_exists( '_w' ) ) {
function _w()
{
	$use	= $GLOBALS;
	unset( $use['_LANG'] );
	unset( $use['smarty']->_tpl_vars['LANG'] );
	unset( $use['_DEFAULTLANG'] );
	_e( $use, 1, 0 );
}
}