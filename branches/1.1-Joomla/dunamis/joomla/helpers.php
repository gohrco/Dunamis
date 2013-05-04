<?php


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
		
		$doc->addScript( 'http' . ( $uri->isSSL() ? 's' : '' ) . '://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js' );
		$doc->addScript( $base . '/libraries/dunamis/dunamis/core/bootstrap/js/noconflict.js' );								// Our noconflict
		$doc->addScript( $base . '/libraries/dunamis/dunamis/core/bootstrap/js/bootstrap.min.js' );								// Our javascript
		$doc->addScript( $base . '/libraries/dunamis/dunamis/core/assets/js/bootstrapSwitch.js' );
	}
}