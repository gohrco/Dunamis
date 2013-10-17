<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Dunamis Core Uri File
 * This is the core Uri handler of the Dunamis Framework
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */


/**
 * Dunamis URI class handler
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.10
 */
class DunUri
{
	/**
	 * The original URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_uri = null;
	
	/**
	 * The scheme portion of URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_scheme = null;
	
	/**
	 * The host portion of the URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_host = null;
	
	/**
	 * The port portion of the URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_port = null;
	
	/**
	 * The username portion of the URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_user = null;
	
	/**
	 * The password portion of the URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_pass = null;
	
	/**
	 * The path portion of the URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_path = null;
	
	/**
	 * The query string portion of the URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_query = null;
	
	/**
	 * The fragment portion of the URI
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_fragment = null;
	
	/**
	 * The variables of the query string
	 * @access		private
	 * @var			array
	 * @since		1.0.0
	 */
	private $_vars = array ();
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $uri: Contains the URI to generate object from
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $uri = null )
	{
		if ( $uri !== null ) {
			$this->parse($uri);
		}
	}
	
	
	/**
	 * Gets an object for the given URI, creating it if it doesn't already exist
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @static
	 * @param		string		- $uri: Contains the URI to retrieve
	 * @param		boolean		- $force: indicates we want a new object [t|F]
	 * 
	 * @return		a DunUri object
	 * @since		1.0.0
	 */
	public static function getInstance($uri = 'SERVER', $force = false)
	{
		static $instances = array();
		
		// Force new URI if we are requesting server incase of changes by other calls
		if ( $uri == 'SERVER' ) {
			$force = true;
		}
		
		if ( $force && isset( $instances[$uri] ) ) {
			unset ($instances[$uri]);
		}
		
		// If we dont have one yet, build it
		if (! isset ( $instances[$uri] ) ) {
			
			// If we didn't ask for a specific uri, lets use the server
			if ( $uri == 'SERVER' ) {
				// Find SSL
				if ( isset($_SERVER['HTTPS'] ) && ! empty( $_SERVER['HTTPS'] ) && ( strtolower( $_SERVER['HTTPS'] ) != 'off' ) ) {
					$https = 's://';
				}
				else {
					$https = '://';
				}
				
				if (! empty ( $_SERVER['PHP_SELF'] ) && ! empty ( $_SERVER['REQUEST_URI'] ) ) {
					$theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				}
				else {
					$theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
					
					// Add the query string if we don't have the server request uri
					if ( isset( $_SERVER['QUERY_STRING'] ) && ! empty( $_SERVER['QUERY_STRING'] ) ) {
						$theURI .= '?' . $_SERVER['QUERY_STRING'];
					}
				}
				
				$theURI = urldecode($theURI);
				$theURI = str_replace('"', '&quot;',$theURI);
				$theURI = str_replace('<', '&lt;',$theURI);
				$theURI = str_replace('>', '&gt;',$theURI);
				$theURI = preg_replace('/eval\((.*)\)/', '', $theURI);
				$theURI = preg_replace('/[\\\"\\\'][\\s]*javascript:(.*)[\\\"\\\']/', '""', $theURI);
			}
			else {
				$theURI = $uri;
			}
			
			$classname	=	'DunUri';
			
			// Create the new instance
			if ( defined( 'DUN_ENV' ) ) {
				$envclassname = ucfirst( strtolower( DUN_ENV ) ) . 'DunUri';
				
				if ( class_exists( $envclassname ) ) {
					$classname	=	$envclassname;
				}
			}
			
			$instances[$uri]	= new $classname( $theURI );
			
		}
		
		return $instances[$uri];
	}
	
	
	/**
	 * Gets the base portion of the URI object
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id )
	 * @version		1.2.0		- static declared explicitly
	 * @param		boolean		- $pathonly: If set will only return the base of the URI [t|F]
	 * 
	 * @return		string containing containing the base portion of the URI
	 * @since		1.0.0
	 */
	public static function base($pathonly = false)
	{
		static $base;
		
		if (! isset( $base ) ) {
			$uri			= self::getInstance();
			$base['prefix'] = $uri->toString( array('scheme', 'host', 'port'));
			
			if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
				//Apache CGI
				$base['path'] =  rtrim(dirname(str_replace(array('"', '<', '>', "'"), '', $_SERVER["PHP_SELF"])), '/\\');
			} else {
				//Others
				$base['path'] =  rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
			}
		}
		
		return $pathonly === false ? $base['prefix'].$base['path'].'/' : $base['path'];
	}
	
	
	/**
	 * Custom method to cleanup a base href for the installer since we haven't determined URI yet
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	public function cleanForInstaller()
	{
		$path	= $this->getPath();
		$parts	= explode('/', $path );
		
		$keep = true;
		foreach ( $parts as $key => $part ) {
			if ( $part == 'install' ) $keep = false;
			if ( $keep ) continue;
			unset( $parts[$key] );
		}
		
		$path = implode( '/', $parts ) . '/';
		$this->setPath( $path );
	}
	
	
	/**
	 * Gets the root of the URI object only
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @version		1.2.0		- static declared explicitly
	 * @param		boolean		- $pathonly: If set will send back only the path [t|F]
	 * @param		string		- $path: If set will return the root with the provided path instead
	 * 
	 * @return		string containing the root of the URI
	 * @since		1.0.0
	 */
	public static function root($pathonly = false, $path = null)
	{
		static $root;
		
		if (! isset( $root ) ) {
			$uri	        =	self :: getInstance( self::base() );
			$root['prefix'] =	$uri->toString( array( 'scheme', 'host', 'port' ) );
			$root['path']   =	rtrim( $uri->toString( array( 'path' ) ), '/\\' );
		}

		// Get the scheme
		if ( isset( $path ) ) {
			$root['path']    = $path;
		}

		return $pathonly === false ? $root['prefix'].$root['path'].'/' : $root['path'];
	}
	
	
	/**
	 * Gets the current URI of the server regardless of the current object
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @version		1.2.0		- static declared explicitly
	 *
	 * @return		string of the current URI
	 * @since		1.0.0
	 */
	public static function current()
	{
		static $current;
		
		if (! isset( $current ) ) {
			$uri	 =	self :: getInstance();
			$current =	$uri->toString( array( 'scheme', 'host', 'port', 'path' ) );
		}
		
		return $current;
	}
	
	
	/**
	 * Takes a URI string and assigns it to the various parts of the object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $uri: the URI to parse
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function parse( $uri )
	{
		$retval = false;
		$this->_uri = $uri;
		
		if ($_parts = $this->_parseURL($uri)) {
			$retval = true;
		}
		
		if(isset ($_parts['query']) && strpos($_parts['query'], '&amp;')) {
			$_parts['query'] = str_replace('&amp;', '&', $_parts['query']);
		}

		$this->_scheme = isset ($_parts['scheme']) ? $_parts['scheme'] : null;
		$this->_user = isset ($_parts['user']) ? $_parts['user'] : null;
		$this->_pass = isset ($_parts['pass']) ? $_parts['pass'] : null;
		$this->_host = isset ($_parts['host']) ? $_parts['host'] : null;
		$this->_port = isset ($_parts['port']) ? $_parts['port'] : null;
		$this->_path = isset ($_parts['path']) ? $_parts['path'] : null;
		$this->_query = isset ($_parts['query'])? $_parts['query'] : null;
		$this->_fragment = isset ($_parts['fragment']) ? $_parts['fragment'] : null;

		if(isset ($_parts['query'])) parse_str($_parts['query'], $this->_vars);
		return $retval;
	}
	
	
	/**
	 * Converts the object to a string
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $parts: contains an array of URI parts to assemble and return (defaults to all)
	 * 
	 * @return		string containing the requested parts of the URI
	 * @since		1.0.0
	 */
	public function toString($parts = array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'))
	{
		$query = $this->getQuery(); //make sure the query is created

		$uri = '';
		$uri .= in_array('scheme', $parts)  ? (!empty($this->_scheme) ? $this->_scheme.'://' : '') : '';
		$uri .= in_array('user', $parts)	? $this->_user : '';
		$uri .= in_array('pass', $parts)	? (!empty ($this->_pass) ? ':' : '') .$this->_pass. (!empty ($this->_user) ? '@' : '') : '';
		$uri .= in_array('host', $parts)	? $this->_host : '';
		$uri .= in_array('port', $parts)	? (!empty ($this->_port) ? ':' : '').$this->_port : '';
		$uri .= in_array('path', $parts)	? $this->_path : '';
		$uri .= in_array('query', $parts)	? (!empty ($query) ? '?'.$query : '') : '';
		$uri .= in_array('fragment', $parts)? (!empty ($this->_fragment) ? '#'.$this->_fragment : '') : '';

		return $uri;
	}
	
	
	/**
	 * Sets a variable to the query array
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: contains the name of the variable to set
	 * @param		mixed		- $value: contains the value of the variable to set
	 * 
	 * @return		mixed containing previous value or null if not set previously
	 * @since		1.0.0
	 */
	public function setVar($name, $value)
	{
		$tmp = ( isset( $this->_vars[$name] ) ? $this->_vars[$name] : null );
		//$tmp = @$this->_vars[$name];
		$this->_vars[$name] = $value;
		$this->_query = null;
		return $tmp;
	}
	
	
	/**
	 * Gets a variable from the query array
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: contains the variable to get the value of
	 * @param		varies		- $default: contains the default value to return if no variable found
	 * 
	 * @return		mixed value of the variable or the default if it isn't set
	 * @since		1.0.0
	 */
	public function getVar( $name = null, $default = null )
	{
		if( isset( $this->_vars[$name] ) ) {
			return $this->_vars[$name];
		}
		
		return $default;
	}
	
	
	/**
	 * Deletes a variable from the query array
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: the query variable to delete from the URI
	 * 
	 * @since		1.0.0
	 */
	public function delVar($name)
	{
		if (in_array($name, array_keys($this->_vars)))
		{
			unset ($this->_vars[$name]);
			$this->_query = null;
		}
	}
	
	
	/**
	 * Deletes all variables from URI object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.1
	 */
	public function delVars()
	{
		$vars = $this->_vars;
		foreach ( $vars as $k => $trash ) $this->delVar( $k );
	}
	
	
	/**
	 * Sets the query to the query array
	 * @access		public
	 * @version		@fileVers@
	 * @param		mixed		- $query: array or string of URI query variables to set
	 * 
	 * @since		1.0.0
	 */
	public function setQuery($query)
	{
		if(!is_array($query)) {
			if(strpos($query, '&amp;') !== false)
			{
			   $query = str_replace('&amp;','&',$query);
			}
			parse_str($query, $this->_vars);
		}

		if(is_array($query)) {
			$this->_vars = $query;
		}

		//empty the query
		$this->_query = null;
	}
	
	
	/**
	 * Gets the query from the query string
	 * @access		public
	 * @version		@fileVers@
	 * @param		boolean		- $toArray: indicates we want the query variables as an array rather than a string
	 * 
	 * @return		string or array
	 * @since		1.0.0
	 */
	public function getQuery( $toArray = false )
	{
		if( $toArray ) {
			return $this->_vars;
		}

		//If the query is empty build it first
		if( is_null( $this->_query ) ) {
			$this->_query = self :: buildQuery($this->_vars);
		}

		return $this->_query;
	}
	
	
	
	/**
	 * Builds a query from an array
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @version		1.2.0		- static declared explicitly
	 * @param		array		- Array containing query variables
	 * @param		string		- If set sets an array string key[akey]
	 * 
	 * @return String containing the query array or false on failure
	 * @since  1.0.0		
	 */
	public static function buildQuery ($params, $akey = null)
	{
		if ( !is_array($params) || count($params) == 0 ) {
			return false;
		}

		$out = array();

		//reset in case we are looping
		if( !isset($akey) && !count($out) )  {
			unset($out);
			$out = array();
		}

		foreach ( $params as $key => $val )
		{
			if ( is_array($val) ) {
				$out[] = DunUri :: buildQuery($val,$key);
				continue;
			}

			$thekey = ( !$akey ) ? $key : $akey.'['.$key.']';
			$out[] = $thekey."=".urlencode($val);
		}

		return implode("&",$out);
	}
	
	
	/**
	 * Gets the scheme of the current URI
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing scheme if set
	 * @since		1.0.0
	 */
	public function getScheme()
	{
		return $this->_scheme;
	}
	
	
	/**
	 * Sets the scheme of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $scheme: sets the scheme for the uri (http|https|etc)
	 * 
	 * @since		1.0.0
	 */
	public function setScheme( $scheme )
	{
		$this->_scheme = $scheme;
	}
	
	
	/**
	 * Gets the username of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing username if set
	 * @since		1.0.0
	 */
	public function getUser()
	{
		return $this->_user;
	}
	
	
	/**
	 * Sets the username of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $user: contains the username to set
	 * 
	 * @since		1.0.0
	 */
	public function setUser( $user )
	{
		$this->_user = $user;
	}
	
	
	/**
	 * Gets the password of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing password if set
	 * @since		1.0.0
	 */
	public function getPass()
	{
		return $this->_pass;
	}
	
	
	/**
	 * Sets the password of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $pass: contains the password to set
	 * 
	 * @since		1.0.0
	 */
	public function setPass( $pass )
	{
		$this->_pass = $pass;
	}
	
	
	/**
	 * Gets the hostname of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing hostname if set
	 * @since		1.0.0
	 */
	public function getHost()
	{
		return $this->_host;
	}
	
	
	/**
	 * Sets the hostname of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $host: the hostname to set
	 * 
	 * @since		1.0.0
	 */
	public function setHost( $host )
	{
		$this->_host = $host;
	}
	
	
	/**
	 * Gets the port number of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing port if set
	 * @since		1.0.0
	 */
	public function getPort()
	{
		return (isset ($this->_port)) ? $this->_port : null;
	}
	
	
	/**
	 * Sets the port number of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $port: the port to set
	 * 
	 * @since		1.0.0
	 */
	public function setPort( $port )
	{
		$this->_port = $port;
	}
	
	
	/**
	 * Gets the path of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing path if set
	 * @since		1.0.0
	 */
	public function getPath()
	{
		return $this->_path;
	}
	
	
	/**
	 * Sets the path of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $path: contains the path to set
	 * 
	 * @since		1.0.0
	 */
	public function setPath( $path )
	{
		$this->_path = $this->_cleanPath($path);
	}
	
	
	/**
	 * Gets the fragment of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing fragment
	 * @since		1.0.0
	 */
	public function getFragment()
	{
		return $this->_fragment;
	}
	
	
	/**
	 * Sets the fragment of the current URI object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $anchor: the fragment to set
	 * 
	 * @since		1.0.0
	 */
	public function setFragment( $anchor )
	{
		$this->_fragment = $anchor;
	}
	
	
	/**
	 * Checks to see if the URI object is a fragment
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function isFragment()
	{
		if (!is_null($this->_scheme)) return false;
		if (!is_null($this->_host)) return false;
		if (!is_null($this->_port)) return false;
		if (!is_null($this->_user)) return false;
		if (!is_null($this->_pass)) return false;
		if (!is_null($this->_path)) return false;
		if (!is_null($this->_query)) return false;
		return true;
	}
	
	
	/**
	 * Checks to see if the URI object is set to SSL
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function isSSL()
	{
		return $this->getScheme() == 'https' ? true : false;
	}
	
	
	/**
	 * Checks to see if the URI is actually an internal url
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public static function isInternal($url)
	{
		$uri	=	DunUri :: getInstance( $url );
		$base	=   $uri->toString(array('scheme', 'host', 'port', 'path'));
		$host	=   $uri->toString(array('scheme', 'host', 'port'));
		if(stripos($base, DunUri::base()) !== 0 && !empty($host)) {
			return false;
		}
		return true;
	}
	
	
	/**
	 * Cleans the path of any undesirable values
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $path: containing the path to clean
	 * 
	 * @return		string containing cleaned path
	 * @since		1.0.0
	 */
	private function _cleanPath( $path )
	{
		$path = explode('/', preg_replace('#(/+)#', '/', $path));
		
		for ($i = 0; $i < count($path); $i ++) {
			if ($path[$i] == '.') {
				unset ($path[$i]);
				$path = array_values($path);
				$i --;
			}
			elseif ($path[$i] == '..' AND ($i > 1 OR ($i == 1 AND $path[0] != ''))) {
				unset ($path[$i]);
				unset ($path[$i -1]);
				$path = array_values($path);
				$i -= 2;
			}
			elseif ($path[$i] == '..' AND $i == 1 AND $path[0] == '') {
				unset ($path[$i]);
				$path = array_values($path);
				$i --;
			} else {
				continue;
			}
		}
		return implode('/', $path);
	}
	
	
	/**
	 * Parses the uri provided
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $uri: contains the URI to parse
	 * 
	 * @return		array containing parsed URL
	 * @since		1.0.0
	 */
	private function _parseURL($uri)
	{
		$parts = array();
		$parts = @parse_url($uri);
		return $parts;
	}
}
?>