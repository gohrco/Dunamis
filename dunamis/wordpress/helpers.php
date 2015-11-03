<?php
/**
 * @package         @packageName@
 * @subpackage		Wordpress
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

// Do not include the script access check - blesta installer needs access to this file before dunamis does




/**
 * Function for retrieving the base url
 * @version		@fileVers@
 * @since		1.5.0
 */
if (! function_exists( 'get_baseurl' ) )
{
	function get_baseurl( $location = 'client' )
	{
		// Grab our Site URL (ssl should be handled by default url function from WP)
		$uri	=	DunUri :: getInstance( rtrim( get_site_url(), '/' ), true );
		
		switch ( $location ) {
			// ----------------------------------------------
			// We are looking for the front end location
			case 'client' :
				return $uri->toString();
				break;
			// ----------------------------------------------
			// We are looking for an admin location
			case 'admin' :
				$uri->setPath( rtrim( $uri->getPath(), '/' ) . '/wp-admin' );
				return $uri->toString();
				break;
			// ----------------------------------------------
			// We are looking for the module location
			default :
				$type	=	WordpressDunModule :: locateModuleType( $location );
				$path	=	WordpressDunModule :: locateModuleUrl( $location ) . $location . '/';
				$uri->setPath( rtrim( $uri->getPath(), '/' ) . $path );
				return $uri->toString();
				break;
			// ----------------------------------------------
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
		return ( defined( "WP_ADMIN" ) == true ? false : true );
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
		
		return false;
	}
}


/**
 * Function for conveniently loading the bootstrap for module
 * @version		@fileVers@
 * @since		1.5.0
 */
if (! function_exists( 'load_bootstrap' ) )
{
	function load_bootstrap( $module = null )
	{
		if ( $module == null ) return;
		
		$base	= rtrim( get_baseurl( 'dunamis' ), '/' );
		$uri	= DunUri :: getInstance( $base, true );
		$uri->delVars();
		
		$doc = dunloader( 'document', true );
		
		$doc->addStyleSheet( $base . '/framework/dunamis/core/bootstrap/css/reset.php?m=' . urlencode( $module ) );			// Reset CSS
		$doc->addStyleSheet( $base . '/framework/dunamis/core/bootstrap/css/bootstrap.2.3.1.php?m=' . urlencode( $module ) );	// Our bootstrap
		$doc->addStyleSheet( $base . '/framework/dunamis/core/assets/css/bootstrapSwitch.php?m=' . urlencode( $module ) );
		
		$doc->addScript( $base . '/framework/dunamis/core/bootstrap/js/bootstrap.min.js' );								// Our javascript
		$doc->addScript( $base . '/framework/dunamis/core/assets/js/bootstrapSwitch.js' );
		
	}
}


/**
 * Used for sending output straight to screen wrapped in <pre> tags or a var dump of a string
 * @version		@fileVers@
 * @param		mixed		- $array: contains the data to output
 * @param		bool		- $die: to kill the application and die on the spot
 *
 * @since		1.0.4
 */
if (! function_exists( '_d' ) ) {
	function _d( $array, $die = false, $setbt = 0 )
	{
		$bt = debug_backtrace();
		$bt = $bt[$setbt];
		
		echo '<h5>' . $bt['file'] . ' @ line ' . $bt['line'] . '</h5>';

		if ( is_string( $array ) ) {
			echo '<pre>'; var_dump( $array ); echo '</pre>';
		}
		else {
			echo '<pre>' . print_r($array,1) . '</pre>';
		}

		if ( $die ) die();
		
	}
}


/**
 * Lists hooks with functions to help determine issues 
 * @version		@fileVers@
 * @param		mixed		- $array: contains the data to output
 * @param		bool		- $die: to kill the application and die on the spot
 *
 * @since		1.5.0
 */
if (! function_exists( 'list_hooked_functions' ) ) {
	function list_hooked_functions($tag=false){
		global $wp_filter;
		if ($tag) {
			$hook[$tag]=$wp_filter[$tag];
			if (!is_array($hook[$tag])) {
				trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
				return;
			}
		}
		else {
			$hook=$wp_filter;
			ksort($hook);
		}
		echo '<pre>';
		foreach($hook as $tag => $priority){
			echo "<br /><h4><u><strong>$tag</strong></u></h4>";
			ksort($priority);
			foreach($priority as $priority => $function){
				echo $priority;
				foreach($function as $name => $properties) echo "$name<br />";
			}
		}
		echo '</pre>';
		return;
	}
}
