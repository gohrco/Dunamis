<?php


if (! function_exists( 'get_baseurl' ) )
{
	function get_baseurl( $location = 'client' )
	{
		$uri	= & DunUri :: getInstance( 'SERVER', true );
		
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


