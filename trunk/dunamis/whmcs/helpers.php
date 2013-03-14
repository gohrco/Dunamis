<?php


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
		return ( defined( "APIAREA" ) == true ? true : false );
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
		
		$doc->addStyleSheet( $base . '/includes/dunamis/whmcs/bootstrap/css/reset.php?m=' . urlencode( $module ) );			// Reset CSS
		$doc->addStyleSheet( $base . '/includes/dunamis/whmcs/bootstrap/css/bootstrap.2.3.1.php?m=' . urlencode( $module ) );	// Our bootstrap
		$doc->addStyleSheet( $base . '/includes/dunamis/whmcs/assets/bootstrapSwitch.php?m=' . urlencode( $module ) );
		
		// Older versions of WHMCS require newer jQuery
		$doc->makeCompatible( '5.2' );
		
		$doc->addScript( $base . '/includes/dunamis/whmcs/bootstrap/js/bootstrap.min.js' );								// Our javascript
		$doc->addScript( $base . '/includes/dunamis/whmcs/assets/bootstrapSwitch.js' );
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
	_e( $use, 1 );
}
}