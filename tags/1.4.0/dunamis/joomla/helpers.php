<?php
/**
 * @package         @packageName@
 * @subpackage		Joomla
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

defined( 'DUNAMIS' ) OR exit('No direct script access allowed');

/**
 * Function for conveniently finding the baseurl for a given location
 * @version		@fileVers@
 * @since		1.1.0
 */
if (! function_exists( 'get_baseurl' ) )
{
	function get_baseurl( $location = 'client' )
	{
		$uri	= DunUri :: getInstance( 'SERVER', true );
		
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
				$path	= WhmcsDunModule :: locateModuleUrl( $location ) . $location . '/';
				$uri->setPath( rtrim( $uri->getPath(), '/' ) . $path );
				return $uri->toString();
				break;
		}
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
		$app	=	JFactory :: getApplication();
		return ( $app->isAdmin() ? true : false );
	}
}


/**
 * Function for determining if we are using SSL on this page or not
 * @version		@fileVers@
 * @since		1.4.0
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
 * Function for conveniently loading the bootstrap for modules
 * @version		@fileVers@
 * @since		1.1.0
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

		$doc->addStyleSheet( $base . '/libraries/dunamis/dunamis/core/bootstrap/css/reset.php?m=' . urlencode( $module ) );			// Reset CSS
		$doc->addStyleSheet( $base . '/libraries/dunamis/dunamis/core/bootstrap/css/bootstrap.2.3.1.php?m=' . urlencode( $module ) );	// Our bootstrap
		$doc->addStyleSheet( $base . '/libraries/dunamis/dunamis/core/assets/css/bootstrapSwitch.php?m=' . urlencode( $module ) );
		
		if ( version_compare( DUN_ENV_VERSION, '3.0.', 'ge' ) ) {
			JHtml :: _( 'bootstrap.framework' );
		}
		else {
			$doc->addScript( 'http' . ( $uri->isSSL() ? 's' : '' ) . '://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js' );
			$doc->addScript( $base . '/libraries/dunamis/dunamis/core/bootstrap/js/noconflict.js' );								// Our noconflict
			$doc->addScript( $base . '/libraries/dunamis/dunamis/core/bootstrap/js/bootstrap.min.js' );								// Our javascript
		}
		
		$doc->addScript( $base . '/libraries/dunamis/dunamis/core/assets/js/bootstrapSwitch.js' );
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