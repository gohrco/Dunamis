<?php
/**
 * @package         @packageName@
 * @subpackage		Blesta
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

defined('DUNAMIS') OR exit('No direct script access allowed');


/**
 * Function for retrieving the base url
 * @version		@fileVers@
 * @since		1.3.0
 */
if (! function_exists( 'get_baseurl' ) )
{
	function get_baseurl( $location = 'client' )
	{
		$hostname	=	isset( Configure::get( "Blesta.company" )->hostname ) ? Configure::get( "Blesta.company" )->hostname : "";
		$http		=	"http" . ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != "off" ? "s" : "" ) . "://";
		
		$tags		= array(
				'base_url'		=>	$http . $hostname . "/",
				'blesta_url'	=>	$http . $hostname . WEBDIR,
				'client_url'	=>	$http . $hostname . WEBDIR . Configure :: get( 'Route.client' ),
				'admin_url'		=>	$http . $hostname . WEBDIR . Configure :: get( 'Route.admin' )
		);
		
		switch ( $location ) :
		case 'client' :
			return $tags['blesta_url'];
			break;
		case 'admin' :
			return $tags['admin_url'];
			break;
		endswitch;
		
		// If we are still here we are looking for a module URL
		dunimport( 'module', true );
		$uri	=	DunUri :: getInstance( $tags['blesta_url'], true );
		$path	=	BlestaDunModule :: locateModuleUrl( $location ) . $location . '/';
		
		$uri->setPath( rtrim( $uri->getPath(), '/' ) . $path );
		return $uri->toString();
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
		$path	=	rtrim( $path, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR . $filename;
		
		return ( file_exists( $path ) ? $path : false );
	}
}

/**
 * Function for determining if we are in the admin area or not
 * @version		@fileVers@
 * @since		1.3.0
 */
if (! function_exists( 'is_admin' ) )
{
	function is_admin()
	{
		if (! defined( 'DUN_ENV_ADMIN' ) ) {
			$parts	=	Router::routesTo( DunUri :: getInstance( 'SERVER', true )->toString() );
			
			if ( is_array( $parts['get'] ) ) {
				foreach ( $parts['get'] as $g ) {
					if ( $g != 'admin' ) continue;
					define( 'DUN_ENV_ADMIN', true );
					break;
				}
			}
		}
		
		return ( defined( "DUN_ENV_ADMIN" ) == true ? true : false );
	}
}


/**
 * Function for determining if we are in an ajax request or not (only known to catch jQuery ajax requests atm)
 * @version		@fileVers@
 * @since		1.3.0
 */
if (! function_exists( 'is_ajax' ) )
{
	function is_ajax()
	{
		return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' );
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
		
		$doc->addStyleSheet( $base . '/plugins/dunamis/framework/dunamis/core/bootstrap/css/reset.php?m=' . urlencode( $module ) );			// Reset CSS
		$doc->addStyleSheet( $base . '/plugins/dunamis/framework/dunamis/core/bootstrap/css/bootstrap.2.3.1.php?m=' . urlencode( $module ) );	// Our bootstrap
		$doc->addStyleSheet( $base . '/plugins/dunamis/framework/dunamis/core/assets/css/bootstrapSwitch.php?m=' . urlencode( $module ) );
		
		$doc->addScript( $base . '/plugins/dunamis/framework/dunamis/core/bootstrap/js/bootstrap.min.js' );								// Our javascript
		$doc->addScript( $base . '/plugins/dunamis/framework/dunamis/core/assets/js/bootstrapSwitch.js' );
		
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
 * Dunamis Installation Helper
 * @desc		This file is a helper file used to install the Dunamis Framework on Blesta
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunHelper
{

	/**
	 * Method to change the file extension for a path/file
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$file		The path/filename to work on
	 * @param		string		$ext		The new extension to use [bak]
	 * @param		boolean		$ow			Indicates we should overwrite an existing file w/ the new extension [TRUE|false]
	 * @param		boolean		$move		Indicates we want to move the file not copy it [TRUE|false]
	 *
	 * @return		boolean
	 * @since		1.3.0
	 */
	public static function changeFileExtension( $file, $ext = 'bak', $ow = true, $move = true )
	{
		$parsed		=	pathinfo( $file );

		$newfile	=	substr( $file, 0, ( -1 * strlen( $parsed['extension'] ) ) ) . $ext;

		// Unable to overwrite
		if ( file_exists( $newfile ) && ! $ow ) {
			return false;
		}
		else {
			unlink ( $newfile );
		}

		if ( $move ) {
			rename( $file, $newfile );
		}
		else {
			if ( function_exists( 'copy' ) ) {
				copy( $file, $newfile );
			}
			// work around for disabled copy
			else {
				$contentx	=	@file_get_contents( $file );
				$openedfile	=	fopen( $newfile, "w");
				fwrite( $openedfile, $contentx );
				fclose( $openedfile );

				if ( $contentx === FALSE ) {
					return false;
				}
			}
		}

		return true;
	}


	/**
	 * Retrieve files given the name and extension sought
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string				The name of the file to search (without extension)
	 * @param		string				The file extension we are searching for
	 * @param		string				The directory to search through
	 *
	 * @return		array				An array of filenames with full paths matching the name and extension sought
	 * @since		1.3.0
	 */
	public static function getFiles( $name = 'structure', $ext = 'pdt', $dir = VIEWDIR )
	{
		$paths	=	self :: _readDirectories( $dir );
		$files	=	array();
		$name	=	$name . '.' . $ext;

		foreach ( $paths as $path ) {
			if (! file_exists( $path . $name ) ) continue;
			if ( is_readable( $path . $name ) ) {
				$files[]	=	$path . $name;
			}
		}

		return $files;
	}


	/**
	 * Method to read a file
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$file		The path/file to read
	 *
	 * @return		string|false			Either the contents of the file or false on failure
	 * @since		1.3.0
	 */
	public static function readFile( $file )
	{
		if ( file_exists( $file ) && is_readable( $file ) && function_exists( 'file_get_contents' ) ) {
			return file_get_contents( $file );
		}

		return false;
	}


	/**
	 * Method to write to a file
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$file		The path/file to write to
	 * @param		string		$content	The content of the new file
	 * @param		boolean		$ow			Indicates we should overwrite an existing file [true|FALSE]
	 *
	 * @return		boolean
	 * @since		1.3.0
	 */
	public static function writeFile( $file, $content, $ow = false )
	{
		if ( file_exists( $file ) && $ow === false ) {
			return false;
		}

		return file_put_contents( $file, $content );
	}


	/**
	 * Method to read directories for directories recursively
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$dir		The directory to walk [VIEWDIR]
	 *
	 * @return		array					Contains an array of directories found
	 * @since		1.3.0
	 */
	private static function _readDirectories( $dir )
	{
		$dh		=	opendir( $dir );
		$dirs	=	array();

		while ( false !== ( $entry = readdir( $dh ) ) ) {
			if ( in_array( $entry, array( '.', '..' ) ) ) continue;
			if ( is_dir( $dir . $entry ) ) {
				$dirs[]		=	$dir . $entry . DIRECTORY_SEPARATOR;
				$subdirs	=	self :: _readDirectories( $dir . $entry . DIRECTORY_SEPARATOR );
				foreach ( $subdirs as $sub ) $dirs[]	=	$sub;
				continue;
			}
		}

		return $dirs;
	}
}