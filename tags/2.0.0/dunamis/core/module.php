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
 * Dunamis Base Module File
 * @desc		This is the core module handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunModule extends DunObject
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: anything we want to set
	 *
	 * @since		1.0.0
	 */
	public function __construct()
	{
		
	}
}


/**
 * Dunamis Core Module File
 * @desc		This is the core module handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class CoreDunModule extends DunModule
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: anything we want to set
	 *
	 * @since		1.0.0
	 */
	public function __construct()
	{

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
	 * @since		2.0.0
	 */
	public static function buildModulePath( $module = null, $type = null )
	{
		$path	=	self :: getModuleTypePath( $type );
		$path	.=	$module . DIRECTORY_SEPARATOR;
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
	 * @since		2.0.0
	 */
	public static function buildModuleUrl( $module = null, $type = null )
	{
		return '/';
	}
	
	
	/**
	 * Method to retrieve the path of a module given a type
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $addon: the type of addon we are looking for
	 *
	 * @return		string
	 * @since		2.0.0
	 */
	public static function getModuleTypePath( $type = 'core' )
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
	 * @version		1.1.1		- July 2013: DUN-2 to correct for custom path being searched first
	 *
	 * @return		array
	 * @since		2.0.0
	 */
	public static function getModuleTypePaths()
	{
		return array(
				'core'			=> DUN_ENV_PATH . 'core' . DIRECTORY_SEPARATOR,
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
	 * Locates a module and returns its module folder path
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 * @param		string		- $folder: a string containing a folder name or null for no dir
	 *
	 * @return		string | false on failure
	 * @since		2.0.0
	 */
	public static function locateModule( $module = null, $folder = null )
	{
		if ( ( $type = self :: locateModuleType( $module ) ) == null ) return false;
		if ( $folder != null ) {
			return self :: buildModulePath( $module, $type ) . $folder . DIRECTORY_SEPARATOR;
		}
		else {
			return self :: buildModulePath( $module, $type );
		}
	}
	
	
	/**
	 * Locates a classname to use and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		2.0.0
	 */
	public static function locateModuleClassname( $module = null )
	{
		$type	= self :: locateModuleType( $module );
		return	'default';
	}
	
	
	/**
	 * Locates a filename and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		2.0.0
	 */
	public static function locateModuleFilename( $module = null )
	{
		$type	= self :: locateModuleType( $module );
		return 'default.php';
	}
	
	
	/**
	 * Locates a module type and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		2.0.0
	 */
	public static function locateModuleType( $module = null )
	{
		$paths	= self :: getModuleTypePaths();
	
		foreach ( $paths as $type => $path ) {
			if (! is_dir( $path . $module ) ) continue;
			if (! file_exists( $path . $module . DIRECTORY_SEPARATOR . $module . '.php' ) ) continue;
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
	 * @since		2.0.0
	 */
	public static function locateModuleUrl( $module = null )
	{
		$type	= self :: locateModuleType( $module );
		return self :: buildModuleUrl( $module, $type );
	}
	
}