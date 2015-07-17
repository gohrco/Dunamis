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
 * Dunamis Module class for Joomla
 * @desc		This is the module extension for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JoomlaDunModule extends DunModule
{
	protected $area	= 'client';
	
	/**
	 * Stores the type of module we are using
	 * @access		protected
	 * @var			string
	 * @since		1.1.0
	 */
	protected $type	= null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.1.0
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
	 * @since		1.1.0
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
	 * @since		1.1.0
	 */
	public static function buildModuleUrl( $module = null, $type = null )
	{
		switch( $type ) {
			case 'custom' :
				return '/';
				break;
			case 'addon' :
				return '/modules/addons/';
				break;
			case 'server' :
				return '/modules/servers/';
				break;
			case 'gateways' :
				return '/modules/gateways/';
				break;
			case 'registrars' :
				return '/modules/registrars/';
				break;
			case 'reports' :
				return '/modules/reports/';
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
	 * @since		1.1.0
	 */
	public static function getModuleTypePath( $type = 'component' )
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
	 * @since		1.1.0
	 */
	public static function getModuleTypePaths()
	{
		$ds	=	DIRECTORY_SEPARATOR;
		return array(
				'component'		=> DUN_ENV_PATH . 'administrator' . $ds . 'components' . $ds,
				'module'		=> DUN_ENV_PATH . 'modules' . $ds,
				'authplugin'	=> DUN_ENV_PATH . 'plugins' . $ds . 'authentication' . $ds,
				'contentplugin'	=> DUN_ENV_PATH . 'plugins' . $ds . 'content' . $ds,
				'searchplugin'	=> DUN_ENV_PATH . 'plugins' . $ds . 'search' . $ds,
				'systemplugin'	=> DUN_ENV_PATH . 'plugins' . $ds . 'system' . $ds,
				'userplugin'	=> DUN_ENV_PATH . 'plugins' . $ds . 'user' . $ds
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
	 * @since		1.1.0
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
	 * @since		1.1.0
	 */
	public static function locateModuleClassname( $module = null )
	{
		$type	= self :: locateModuleType( $module );
	
		switch( $type ) {
			case 'component' :
			case 'module' :
			case 'authplugin' :
			case 'contentplugin' :
			case 'searchplugin' :
			case 'systemplugin' :
			case 'userplugin' :
				$classname	=	null;
				break;
		}
		
		return $classname;
	}
	
	
	/**
	 * Locates a filename and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		1.1.0
	 */
	public static function locateModuleFilename( $module = null )
	{
		// Find the type first
		$type	= self :: locateModuleType( $module );
		
		switch( $type ) {
			case 'component' :
				$filename	=	( strpos( $module, 'com_' ) !== false ? str_replace( 'com_', '', $module ) : $module ) . '.dunamis.php';
				break;
			case 'module' :
			case 'authplugin' :
			case 'contentplugin' :
			case 'searchplugin' :
			case 'systemplugin' :
			case 'userplugin' :
				$filename	=	$module . '.dunamis.php';
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
	 * @since		1.1.0
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
	 * @since		1.1.0
	 */
	public static function locateModuleUrl( $module = null )
	{
		$type	= self :: locateModuleType( $module );
		return self :: buildModuleUrl( $module, $type );
	}
}