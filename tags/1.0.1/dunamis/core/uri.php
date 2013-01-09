<?php

class DunUri
{
	/**
	 * The original URI
	 * 
	 * @var  string
	 */
	var $_uri = null;
	
	/**
	 * The scheme portion of URI
	 * 
	 * @var  string
	 */
	var $_scheme = null;
	
	/**
	 * The host portion of the URI
	 * 
	 * @var  string
	 */
	var $_host = null;
	
	/**
	 * The port portion of the URI
	 * 
	 * @var  string
	 */
	var $_port = null;
	
	/**
	 * The username portion of the URI
	 * 
	 * @var  string
	 */
	var $_user = null;
	
	/**
	 * The password portion of the URI
	 * 
	 * @var  string
	 */
	var $_pass = null;
	
	/**
	 * The path portion of the URI
	 * 
	 * @var  string
	 */
	var $_path = null;
	
	/**
	 * The query string portion of the URI
	 * 
	 * @var  string
	 */
	var $_query = null;
	
	/**
	 * The fragment portion of the URI
	 * 
	 * @var  string
	 */
	var $_fragment = null;
	
	/**
	 * The variables of the query string
	 * 
	 * @var  array
	 */
	var $_vars = array ();
	
	
	/**
	 * Constructor
	 * 
	 * @param  string		Contains the URI to generate object from
	 * 
	 * @since  3.0.0
	 */
	function __construct( $uri = null )
	{
		if ($uri !== null) {
			$this->parse($uri);
		}
	}
	
	
	/**
	 * Gets an object for the given URI, creating it if it doesn't exist
	 * 
	 * @param  string		Contains the URI to retrieve
	 * @param  boolean		If set will force a new object to be created
	 * 
	 * @return An URI object
	 * @since  3.0.0
	 */
	function &getInstance($uri = 'SERVER', $force = false)
	{
		static $instances = array();
		
		if ($force && isset($instances[$uri]))
			unset ($instances[$uri]);
		
		if (!isset ($instances[$uri])) {
			if ($uri == 'SERVER') {
				if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) {
					$https = 's://';
				} else {
					$https = '://';
				}
				if (!empty ($_SERVER['PHP_SELF']) && !empty ($_SERVER['REQUEST_URI'])) {
					$theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				}
				else {
					$theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
					if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
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

			// Create the new Uri instance
			$instances[$uri] = new DunUri($theURI);
		}
		return $instances[$uri];
	}
	
	
	/**
	 * Gets the base portion of the URI object
	 * 
	 * @param  boolean		If set will only return the base of the URI
	 * 
	 * @return A string containing the base portion of the URI
	 * @since  3.0.0
	 */
	function base($pathonly = false)
	{
		static $base;
		
		if (!isset($base))
		{
			$uri			= & DunUri::getInstance();
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
	 * @since		3.0.2
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
	 * 
	 * @param  boolean		If set will send back only the path
	 * @param  string		If set will return the root with the provided path instead
	 * 
	 * @return A string containing the root of the URI
	 * @since  3.0.0
	 */
	function root($pathonly = false, $path = null)
	{
		static $root;
		
		if(!isset($root))
		{
			$uri	        =& DunUri::getInstance(DunUri::base());
			$root['prefix'] = $uri->toString( array('scheme', 'host', 'port') );
			$root['path']   = rtrim($uri->toString( array('path') ), '/\\');
		}

		// Get the scheme
		if(isset($path)) {
			$root['path']    = $path;
		}

		return $pathonly === false ? $root['prefix'].$root['path'].'/' : $root['path'];
	}
	
	
	/**
	 * Gets the current URI of the server regardless of the current object
	 * 
	 * @return A string of the current URI
	 * @since  3.0.0
	 */
	function current()
	{
		static $current;
		
		if (!isset($current))
		{
			$uri	 = & DunUri::getInstance();
			$current = $uri->toString( array('scheme', 'host', 'port', 'path'));
		}
		return $current;
	}
	
	
	/**
	 * Takes a URI string and assigns it to the various parts of the object
	 * 
	 * @param  string		Containing the URI to parse
	 * 
	 * @return True on success, false on failure
	 * @since  3.0.0
	 */
	function parse($uri)
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
	 * 
	 * @param  array		If set contains an array of URI parts to assemble and return
	 * 
	 * @return A string containing the requested parts of the URI
	 * @since  3.0.0 
	 * @see    IntObject::toString()
	 */
	function toString($parts = array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'))
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
	 * 
	 * @param  string		Contains the name of the variable to set
	 * @param  varies		Contains the value of the variable to set
	 * 
	 * @return If there was a previous value, or null
	 * @since  3.0.0
	 */
	function setVar($name, $value)
	{
		$tmp = ( isset( $this->_vars[$name] ) ? $this->_vars[$name] : null );
		//$tmp = @$this->_vars[$name];
		$this->_vars[$name] = $value;
		$this->_query = null;
		return $tmp;
	}
	
	
	/**
	 * Gets a variable from the query array
	 * 
	 * @param  string		Contains the variable to get the value of
	 * @param  varies		Contains the default value to return if no variable found
	 * 
	 * @return Returns the value of the variable or the default if it isn't set
	 * @since  3.0.0
	 */
	function getVar($name = null, $default=null)
	{
		if(isset($this->_vars[$name])) {
			return $this->_vars[$name];
		}
		return $default;
	}
	
	
	/**
	 * Deletes a variable from the query array
	 * 
	 * @param  string		Contains the variable to delete
	 * 
	 * @since  3.0.0
	 */
	function delVar($name)
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
	function delVars()
	{
		$vars = $this->_vars;
		foreach ( $vars as $k => $trash ) $this->delVar( $k );
	}
	
	
	/**
	 * Sets the query to the query array
	 * 
	 * @param  string		Contains the query of the URI to parse into the variable array
	 * 
	 * @since  3.0.0
	 */
	function setQuery($query)
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
	 * 
	 * @param  boolean		If set will return an array rather than string
	 * 
	 * @return Returns the query string either as a string or as an array
	 * @since  3.0.0
	 */
	function getQuery($toArray = false)
	{
		if($toArray) {
			return $this->_vars;
		}

		//If the query is empty build it first
		if(is_null($this->_query)) {
			$this->_query = $this->buildQuery($this->_vars);
		}

		return $this->_query;
	}
	
	
	
	/**
	 * Builds a query from an array
	 * 
	 * @param  array		Array containing query variables
	 * @param  string		If set sets an array string key[akey]
	 * 
	 * @return String containing the query array or false on failure
	 * @since  3.0.0		
	 */
	function buildQuery ($params, $akey = null)
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
				$out[] = JURI::buildQuery($val,$key);
				continue;
			}

			$thekey = ( !$akey ) ? $key : $akey.'['.$key.']';
			$out[] = $thekey."=".urlencode($val);
		}

		return implode("&",$out);
	}
	
	
	/**
	 * Gets the scheme of the current URI
	 * 
	 * @return String containing scheme
	 * @since  3.0.0
	 */
	function getScheme()
	{
		return $this->_scheme;
	}
	
	
	/**
	 * Sets the scheme of the current URI object
	 * 
	 * @param  string		Contains the scheme to set
	 * 
	 * @since  3.0.0
	 */
	function setScheme($scheme)
	{
		$this->_scheme = $scheme;
	}
	
	
	/**
	 * Gets the username of the current URI object
	 * 
	 * @return String containing the username
	 * @since  3.0.0
	 */
	function getUser()
	{
		return $this->_user;
	}
	
	
	/**
	 * Sets the username of the current URI object
	 * 
	 * @param  string		Containing the username to set
	 * 
	 * @since  3.0.0
	 */
	function setUser($user)
	{
		$this->_user = $user;
	}
	
	
	/**
	 * Gets the password of the current URI object
	 * 
	 * @return String containing the password
	 * @since  3.0.0
	 */
	function getPass()
	{
		return $this->_pass;
	}
	
	
	/**
	 * Sets the password of the current URI object
	 * 
	 * @param  string		Contains the password to set
	 * 
	 * @since  3.0.0
	 */
	function setPass($pass)
	{
		$this->_pass = $pass;
	}
	
	
	/**
	 * Gets the hostname of the current URI object
	 * 
	 * @return String containing the hostname
	 * @since  3.0.0
	 */
	function getHost()
	{
		return $this->_host;
	}
	
	
	/**
	 * Sets the hostname of the current URI object
	 * 
	 * @param  string		Containing the hostname to set
	 * 
	 * @since  3.0.0
	 */
	function setHost($host)
	{
		$this->_host = $host;
	}
	
	
	/**
	 * Gets the port number of the current URI object
	 * 
	 * @return String containing the port number or null if not set
	 * @since  3.0.0
	 */
	function getPort()
	{
		return (isset ($this->_port)) ? $this->_port : null;
	}
	
	
	/**
	 * Sets the port number of the current URI object
	 * 
	 * @param  string		Contains the port number to set
	 * 
	 * @since  3.0.0
	 */
	function setPort($port)
	{
		$this->_port = $port;
	}
	
	
	/**
	 * Gets the path of the current URI object
	 * 
	 * @return String containing the path
	 * @since  3.0.0
	 */
	function getPath()
	{
		return $this->_path;
	}
	
	
	/**
	 * Sets the path of the current URI object
	 * 
	 * @param  string		Contains the path to set
	 * 
	 * @since  3.0.0
	 */
	function setPath($path)
	{
		$this->_path = $this->_cleanPath($path);
	}
	
	
	/**
	 * Gets the fragment of the current URI object
	 * 
	 * @return String containing the fragment
	 * @since  3.0.0
	 */
	function getFragment()
	{
		return $this->_fragment;
	}
	
	
	/**
	 * Sets the fragment of the current URI object
	 * 
	 * @param  string		Containing the fragment value to set
	 * 
	 * @since  3.0.0
	 */
	function setFragment($anchor)
	{
		$this->_fragment = $anchor;
	}
	
	
	/**
	 * Checks to see if the URI object is a fragment
	 * 
	 * @return True if so, false if not
	 * @since  3.0.0
	 */
	function isFragment()
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
	 * 
	 * @return True if so, false if not
	 * @since  3.0.0
	 */
	function isSSL()
	{
		return $this->getScheme() == 'https' ? true : false;
	}
	
	
	/**
	 * Checks to see if the URI is actually an internal url
	 * 
	 * @param  string		Contains the URL to check
	 * 
	 * @return True if it is, false if not
	 * @since  3.0.0
	 */
	function isInternal($url)
	{
		$uri	= & DunUri::getInstance($url);
		$base	=   $uri->toString(array('scheme', 'host', 'port', 'path'));
		$host	=   $uri->toString(array('scheme', 'host', 'port'));
		if(stripos($base, DunUri::base()) !== 0 && !empty($host)) {
			return false;
		}
		return true;
	}
	
	
	/**
	 * Cleans the path of any undesirable values
	 * 
	 * @param  string		Containing the path to clean
	 * 
	 * @return String containing cleaned path
	 * @since  3.0.0
	 */
	private function _cleanPath($path)
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
	 * 
	 * @param  string		Contains the URI to parse
	 * 
	 * @return An array of URI parts
	 * @since  3.0.0
	 */
	private function _parseURL($uri)
	{
		$parts = array();
		$parts = @parse_url($uri);
		return $parts;
	}
}
?>