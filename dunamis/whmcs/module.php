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
 * Dunamis Module class for WHMCs
 * @desc		This is our base module class for our modules for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunModule extends DunModule
{
	protected $area	= 'client';
	
	/**
	 * Stores the type of module we are using
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $type	= null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
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
	 * @since		1.0.0
	 */
	public static function buildModulePath( $module = null, $type = null )
	{
		$path = self :: getModuleTypePath( $type );
	
		switch( $type ) {
			case 'custom' :
	
				break;
			case 'addon' :
			case 'server' :
			case 'gateways' :
			case 'registrars' :
				$path .= $module . DIRECTORY_SEPARATOR;
				break;
			case 'reports' :
	
				break;
		}
	
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
	 * @since		1.0.0
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
	 * @since		1.0.0
	 */
	public static function getModuleTypePath( $type = 'addon' )
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
	 * @since		1.0.0
	 */
	public static function getModuleTypePaths()
	{
		return array(
				'addon'			=> DUN_ENV_PATH . 'modules' . DIRECTORY_SEPARATOR . 'addons' . DIRECTORY_SEPARATOR,
				'server'		=> DUN_ENV_PATH . 'modules' . DIRECTORY_SEPARATOR . 'servers' . DIRECTORY_SEPARATOR,
				'gateways'		=> DUN_ENV_PATH . 'modules' . DIRECTORY_SEPARATOR . 'gateways' . DIRECTORY_SEPARATOR,
				'registrars'	=> DUN_ENV_PATH . 'modules' . DIRECTORY_SEPARATOR . 'registrars' . DIRECTORY_SEPARATOR,
				'reports'		=> DUN_ENV_PATH . 'modules' . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR,
				'custom'		=> DUN_ENV_PATH,
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
	 * @since		1.0.0
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
	 * @since		1.0.0
	 */
	public static function locateModuleClassname( $module = null )
	{
		$type	= self :: locateModuleType( $module );
	
		switch( $type ) {
			case 'custom' :
	
				break;
			case 'addon' :
			case 'server' :
			case 'gateways' :
			case 'registrars' :
				
				if ( is_api() ) return 'api';
				
				return ( is_admin()
				? 'admin'
				: ( is_api()
					? 'api'
					: 'client'
					)
				);
				break;
			case 'reports' :
	
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
	 * @since		1.0.0
	 */
	public static function locateModuleFilename( $module = null )
	{
		$type	= self :: locateModuleType( $module );
		
		switch( $type ) {
			case 'custom' :
	
				break;
			case 'addon' :
			case 'server' :
			case 'gateways' :
			case 'registrars' :
				
				if ( is_api() ) return 'api.php';
				
				return ( is_admin()
				? 'admin.php'
				: ( is_api()
					? 'api.php'
					: 'client.php'
					)
				);
				break;
			case 'reports' :
	
				break;
		}
	}
	
	
	/**
	 * Locates a module type and returns it
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		string		- $module: the name of the module to locate
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public static function locateModuleType( $module = null )
	{
		$paths	= self :: getModuleTypePaths();
		
		foreach ( $paths as $type => $path ) {
			if (! is_dir( $path . $module ) ) continue;
			
			// ---- BEGIN DUN-2
			//		Create a verification to ensure we have found our module
			if (! file_exists( $path . $module . DIRECTORY_SEPARATOR . $module . '.php' ) ) continue;
			// ---- END DUN-2
			
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
	 * @since		1.0.0
	 */
	public static function locateModuleUrl( $module = null )
	{
		$type	= self :: locateModuleType( $module );
		return self :: buildModuleUrl( $module, $type );
	}
}