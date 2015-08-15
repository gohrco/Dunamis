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

defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * ========================================
 *  STILL TO BE DONE
 * ======================================== 
 */
/**
 * Dunamis Module class for Wordpress
 * @desc		This is our base module class for our modules for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Wordpress
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunModule extends DunModule
{
	protected $area	= 'client';
	
	/**
	 * Stores the type of module we are using
	 * @access		protected
	 * @var			string
	 * @since		1.5.0
	 */
	protected $type	= null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.5.0
	 * @see			DunModule :: __construct()
	 */
	public function __construct()
	{
		parent :: __construct();
	}
	
	
	
	/**
	 * Builds a module path based on its type
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the module name to build for
	 * @param		string		- $type: the type of module to build
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public static function buildModulePath( $module = null, $type = null )
	{
		$path	=	self :: getModuleTypePath( $type )
				.	$module . DIRECTORY_SEPARATOR;
		
		return $path;
	}
	
	
	/**
	 * Builds a module url based on its type
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the module name to build for
	 * @param		string		- $type: the type of module to build
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public static function buildModuleUrl( $module = null, $type = null )
	{
		switch( $type ) {
			case 'plugin' :
				return '/wp-content/plugins/';
				break;
			case 'theme' :
				return '/wp-content/themes/';
				break;
		}
	}
	
	
	/**
	 * Method to retrieve the path of a module given a type
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $addon: the type of addon we are looking for
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public static function getModuleTypePath( $type = 'plugin' )
	{
		$paths	= self :: getModuleTypePaths();
		if (! isset( $paths[$type] ) ) return null;
		return $paths[$type];
	}
	
	
	/**
	 * Retrieves an array of paths
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 *
	 * @return		array
	 * @since		1.5.0
	 */
	public static function getModuleTypePaths()
	{
		$ds	=	DIRECTORY_SEPARATOR;
		return array(
				'plugin'			=> DUN_ENV_PATH . 'wp-content' . $ds . 'plugins' . $ds,
				'theme'				=> DUN_ENV_PATH . 'wp-content' . $ds . 'themes' . $ds,
		);
	}
	
	
	/**
	 * Determines what type of module this is
	 * @param unknown_type $module
	 */
	public function getModuleType( $module = null )
	{
		
	}
	
	
	/**
	 * Locates a module and returns the appropriate path
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 * @param		string		- $folder: a string containing a folder name or null for no dir
	 * 
	 * @return		string | false on failure
	 * @since		1.5.0
	 */
	public static function locateModule( $module = null, $folder = null )
	{
		// Find the type first
		$type	=	self :: locateModuleType( $module );
		if ( $type == null ) return false;	// Unable to locate type
		
		// Get the base path
		$path	=	self :: buildModulePath( $module, $type );
		
		if ( $folder != null ) {
			$path	.=	$folder . DIRECTORY_SEPARATOR;
		}
		
		return $path;
	}
	
	
	/**
	 * Locates a classname to use and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public static function locateModuleClassname( $module = null )
	{
		$type	= self :: locateModuleType( $module );
	
		switch( $type ) {
			case 'plugin' :
			case 'theme' :
				
				if ( is_api() ) {
					return 'api';
				}
				else if ( is_admin() ) {
					return 'admin';
				}
				else {
					return 'client';
				}
				
				break;
		}
	}
	
	
	/**
	 * Locates a filename and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public static function locateModuleFilename( $module = null )
	{
		// Find the type first
		$type	= self :: locateModuleType( $module );
		
		switch( $type ) {
			case 'plugin' :
			case 'theme' :
				
				if ( is_api() ) {
					return 'api.php';
				}
				else if ( is_admin() ) {
					return 'admin.php';
				}
				else {
					return 'client.php';
				}
		}
		
		return $filename;
	}
	
	
	/**
	 * Locates a module type and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public static function locateModuleType( $module = null )
	{
		$paths	= self :: getModuleTypePaths();
		
		foreach ( $paths as $type => $path ) {
			if (! is_dir( $path . $module ) ) continue;
			return $type; 
		}
		
		return null;
	}
	
	
	/**
	 * Locates a module url and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public static function locateModuleUrl( $module = null )
	{
		$type	= self :: locateModuleType( $module );
		return self :: buildModuleUrl( $module, $type );
	}
}