<?php
/**
 * Dunamis Inclusion File
 * This is the core of the Dunamis Framework
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */


// Set the DUNAMIS definition
if (! defined( 'DUNAMIS' ) ) define( 'DUNAMIS', '@fileVers@' );


/**
 * Singleton function for grabbing Dunamis
 * @version		@fileVers@
 * @param		string		- $module: the name of the module calling up the framework
 * @param		boolean		- $force: if we want to force a new version we can set this true
 * 
 * @return		instance of Dunamis
 * @since		1.0.0
 */
function &get_dunamis( $module = null )
{
	// We must specify a module
	if ( $module == null ) return false;
	
	static $instances = null;
	
	// If this the first go around
	if (! is_object( $instances ) ) {
		$instances = new Dunamis();
		$instances->initialise();
	}
	
	// We have an instance so now lets load the module
	if(! $instances->loadModule( $module ) ) {
		// Throw an error somehow
		echo '<pre>'.print_r(debug_backtrace(false),1);
		die('problem');
		return false;
	}
	
	return $instances;
}


/**
 * Dunamis class
 * @version		@fileVers@
 * @author		Steven
 * 
 * @since		1.0.0
 */
class Dunamis
{
	/**
	 * Stores a reference to the database object
	 * @access		public
	 * @var			object
	 * @since		1.0.0
	 */
	public $db			= null;
	
	/**
	 * Stores names of modules loaded up
	 * @access		protected
	 * @static
	 * @var			array
	 * @since		1.0.0
	 */
	protected $modules	= array();
	
	/**
	 * Stores the environment object we find ourselves in
	 * @access		private
	 * @var			object
	 * @since		1.0.0
	 */
	private $_environment	= null;
	
	/**
	 * Stores the environment name we found ourselves in
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_environmentname	= null;
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function __constructor() {}
	
	
	/**
	 * Method to get a module path
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $module: the module name to find the path for
	 * @param		string		- $folder: the folder to add to the path
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function getModulePath( $module = null, $folder = 'dunamis' )
	{
		dunimport( 'module', true );
		$classname	= ucfirst( $this->_environmentname ) . 'DunModule';
		return $classname :: locateModule( $module, $folder );
	}
	
	
	/**
	 * Method to initialise Dunamis
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function initialise()
	{
		// Initialize the base
		$this->_load_base();
		
		// Find the environment
		$this->_find_environment();
		
		dunimport( 'uri', true );
	}
	
	
	/**
	 * Method to load a different environment else load existing
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $override: if we want to load an environment object of another type we can
	 * 
	 * @return		boolean or object
	 * @since		1.0.0
	 */
	public function loadEnvironment( $override = null )
	{
		// If we are overriding then be sure we have previously included file
		if ( $override != null ) {
			dunimport( $override . '.environment' );
			
			$classname	= ucfirst( $override ) . 'DunEnvironment';
			if ( class_exists( $classname ) ) {
				return new $classname();
			}
		}
		
		$classname	= ucfirst( $this->_environmentname ) . 'DunEnvironment';
		if ( class_exists( $classname ) ) {
			$this->_environment = new $classname();
			
			// Be sure to set the defines
			$this->_environment->defines();
		}
		
		return $this->_environment;
	}
	
	
	/**
	 * Loads a module into place
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $module: the module to load up
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function loadModule( $module = null )
	{
		if ( array_key_exists( $module, $this->modules ) ) return $this->modules[$module];
		
		$subclass = null;
		
		if ( strpos( $module, '.' ) !== false ) {
			list( $module, $subclass ) = explode( '.', $module );
		}
		
		dunimport( 'module', true );
		$classname	= ucfirst( $this->_environmentname ) . 'DunModule';
		$path		= $classname :: locateModule( $module );
		$filename	= ( $subclass != null ? $subclass . '.php' : $classname :: locateModuleFilename( $module ) );
		$subclass	= ( $subclass != null ? $subclass : $classname :: locateModuleClassname( $module ) );
		
		include_once( $path . $filename );
		
		$classname				= ucfirst( $module ) . ucfirst( $subclass ) . 'DunModule';
		$this->modules[$module]	= false;
		
		if (! class_exists( $classname ) ) {
			return false;
		}
		
		// Setup the new module
		$this->modules[$module] = new $classname();
		$this->modules[$module]->initialise();
		return $this->modules[$module];
	}
	
	
	/**
	 * Method to find which environment we are in
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	private function _find_environment()
	{
		// If we already know then don't do this again
		if ( $this->_environmentname != null ) return true;
		
		$excludes	= array( '.', '..', 'core' );
		$d	= opendir( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dunamis' );
		
		while( ( $dirname = readdir( $d ) ) !== false ) {
			if ( in_array( $dirname, $excludes ) ) continue;
			dunimport( $dirname . '.environment' );
			
			// Test to see if this is the environment
			if ( call_user_func( 'is_this_' . $dirname ) ) {
				$this->_environmentname = $dirname;
				break;
			}
		}
		
		$this->loadEnvironment();
		
		return true;
	}
	
	
	/**
	 * Method to initialise the base environment
	 * @access		@private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	private function _load_base()
	{
		$files	= array( 'object', 'environment' );
		
		foreach ( $files as $file ) {
			dunimport( 'core.' . $file );
		}
	}
}



/**
 * Function to import files
 * @param		string		- $request: contains path to filename
 * @param		bool		- $dunpath: indicates we should be relative to dunpath; false relative to environment
 * @param		bool		- $reverse: indicates we should load environment file first
 * 
 * @return		boolean
 * @since		1.0.0
 */
function dunimport( $request = null, $environment = false, $reverse = false )
{
	static $includes = array();
	
	$ext	= '.php';
	$paths	= array();
	
	foreach ( array( '.php', '.xml' ) as $check ) {
		if ( strstr( $request, $check ) !== false ) {
			$request	= strstr( $request, $check, true );
			$ext		= $check;
			break;
		}
	}
	
	/* ------------------------------
	 * Determine the appropriate path
	 * ------------------------------ */
	//	Assume if we don't have DUN_PATH we haven't loaded anything yet
	if (! defined( 'DUN_PATH' ) ) {
		$paths['core']	= dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'dunamis' . DIRECTORY_SEPARATOR;
	}
	//	If we have an environment - we are recursively checking for module paths then environment then core else default to the environment path
	else if ( $environment ) {
		
		$paths['core']	= DUN_CORE;
		$paths['env']	= DUN_PATH . strtolower( DUN_ENV ) . DIRECTORY_SEPARATOR;
		
		if ( $reverse === true ) {
			$paths	= array_reverse( $paths );
		}
		
		if ( defined( 'DUN_MOD_' . strtoupper( $environment ) ) ) {
			// Get Dunamis
			$paths['mod'] = get_dunamis( $environment )->getModulePath( $environment );
		}
		
	}
	// 	If all else fails use the dunamis root path (ie core.object works)
	else {
		$paths['root']	= DUN_PATH;
		$paths['core']	= DUN_CORE;
	}
	
	
	// If we've been here before...
	if ( isset( $includes[$request] ) ) return $includes[$request];
	
	foreach ( $paths as $i => $path )
		$paths[$i]	= $path . str_replace( '.', DIRECTORY_SEPARATOR, $request ) . $ext;
	
	$includes[$request] = false;
	
	// Found and bail
	foreach ( $paths as $loc => $path ) {
		if ( file_exists( $path ) ) {
			include_once( $path );
			$includes[$request] = $loc;
		}
	}
	
	return $includes[$request];
}


/**
 * Function to import and instantiate a class
 * @version		@fileVers@
 * @param		string		- $request: contains path to filename
 * @param		string		- $environment: string containing module or true containing environment or false containing core
 * 
 * @return		object
 * @since		1.0.0
 */
function dunloader( $request = null, $environment = false )
{
	static $instances	= array();
	
	if (! array_key_exists( $request, $instances ) ) { //$instances[$request] ) {
		dunimport( $request, $environment );
		
		if ( is_string( $environment ) ) {
			$class	= ucfirst( $environment ) . 'Dun' . ucfirst( $request );
		}
		else if ( $environment === true ) {
			$class	= DUN_ENV;
			$class	= ucfirst( strtolower( $class ) ) . 'Dun' . ucfirst( $request );
		}
		else {
			$class	= 'Dun' . ucfirst( $request );
		}
		
		$instances[$request] = & $class :: getInstance();
	}
	
	return $instances[$request];
}


/**
 * Function to find and return the appropriate module file
 * @version		@fileVers@
 * @param		string		- $request:  the module to load
 * 
 * @return		object
 * @since		1.0.0
 */
function dunmodule( $request )
{
	$dun	= & get_dunamis( $request );
	return $dun->loadModule( $request );
	
}