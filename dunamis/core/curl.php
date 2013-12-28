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
 * Dunamis Core Curl File
 * @desc		This is the core CURL handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunCurl extends DunObject
{
	/**
	 * Permits recursion of CURL when 500 received
	 * @access		private
	 * @var			integer
	 * @since		3.0.0 (0.4)
	 */
	public $count			= 0;
	
	/**
	 * Contains the curl response for debugging
	 * @access		private
	 * @var			string
	 * @since		3.0.0
	 */
	private	$response		= '';
	
	/**
	 * Contains the curl handler for a session
	 * @access		private
	 * @var			object
	 * @since		3.0.0
	 */
	private	$session		= null;
	
	/**
	 * The url of the session
	 * @access		private
	 * @var			string
	 * @since		3.0.0
	 */
	private	$url			= null;
	
	/**
	 * The options set to the curl_setopt array
	 * @access		private
	 * @var			array
	 * @since		3.0.0
	 */
	private	$options		= array();
	
	/**
	 * The extra HTTP headers to set
	 * @access 		private
	 * @var			array
	 * @since		3.0.0
	 */
	private	$headers		= array();
	
	/**
	 * The error code returned by the curl handler
	 * @access		public
	 * @var			integer
	 * @since		3.0.0
	 */
	public	$error_code		= null;
	
	/**
	 * The error message returned by the curl handler
	 * @access		public
	 * @var			string
	 * @since		3.0.0
	 */
	public	$error_string	= null;
	
	/**
	 * The information array from the curl handler request
	 * @access		public
	 * @var			array
	 * @since		3.0.0
	 */
	public	$info			= array();
	
	/**
	 * The response stored for debugging purposes
	 * @access		public
	 * @var			string
	 * @since		3.0.0
	 */
	public	$debugresponse	= null;
	
	/**
	 * The method used for the curl call
	 * @access		public
	 * @var			string
	 * @since		3.0.0
	 */
	public	$debugmethod	= null;
	
	/**
	 * We store the options used for curl here
	 * @access		public
	 * @var			array
	 * @since		1.2.2
	 */
	public	$debugoptions	=	array();
	
	/**
	 * The posted variables to the curl call
	 * @access		public
	 * @var			array
	 * @since		3.0.0
	 */
	public	$debugpost		= array();
	
	
	/**
	 * Constructor
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $properties: setting to create object with
	 *
	 * @since		1.0.0
	 */
	public function __construct()
	{
		if ( ! $this->is_enabled()) {
			exit( 'cURL Class - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');
		}
	}
	
	
	/**
	 * Call constructor - when a method is called
	 * @access		public
	 * @version		@fileVers@
	 * @param 		string		- $method: the name of the method being called
	 * @param 		array		- $arguments: the arguments passed to the method
	 *
	 * @return		redirect to appropriate method
	 * @since		1.0.0
	 */
	public function __call( $name, $arguments )
	{
		if ( in_array( $name, array( 'simple_get', 'simple_post', 'simple_put', 'simple_delete') ) ) {
			// Take off the "simple_" and past get/post/put/delete to _simple_call
			$verb = str_replace( 'simple_', '', $name );
			array_unshift( $arguments, $verb );
			return call_user_func_array( array( $this, '_simple_call' ), $arguments );
		}
		
		/* GETTER */
		if ( strpos( $name, 'get' ) !== false && strpos( $name, 'get' ) == 0 ) {
			$var		=	strtolower( preg_replace( "#^get#", '', $name ) );
			$default	=	(! empty( $arguments ) ? $arguments[0] : false );
				
			if ( isset( $this->$var ) ) {
				return $this->$var;
			}
		}
		
		/* SETTER */
		if ( strpos( $name, 'set' ) !== false && strpos( $name, 'set' ) == 0 ) {
			// Lets try object properties first
			$var		=	strtolower( preg_replace( "#^set#", '', $name ) );
			$value		=	(! empty( $arguments ) ? $arguments[0] : false );
				
			if ( property_exists( get_class( $this ), $var ) ) {
				$this->$var = $value;
				return $this;
			}
		}
		
		/* HASER */
		if ( strpos( $name, 'has' ) !== false && strpos( $name, 'has' ) == 0 ) {
			// Lets try object properties first
			$var		=	strtolower( preg_replace( "#^has#", '', $name ) );
				
			if ( isset( $this->$var ) && ! empty( $this->$var ) ) {
				return true;
			}
		}
		
		return parent :: __call( $name, $arguments );
	}
	
	
	/**
	 * Instantiate the object
	 * @access		public
	 * @version		@fileVers@
	 * @version		1.2.0		- Oct 2013: permit serialization of curl handler options for multiple instances
	 * @param		array		- $options: to pass along to instance
	 * 
	 * @return		instance of self
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance	=	array();
		$serialize			=	serialize( $options );
		
		if (! isset( $instance[$serialize] ) || ! is_object( $instance[$serialize] ) ) {
			$class		= null;
			$classes	= array( 'DunCurl' );
			
			if ( defined( 'DUN_ENV' ) ) {
				array_unshift( $classes, ucfirst( strtolower( DUN_ENV ) ) . 'DunCurl' );
			}
			
			foreach ( $classes as $classname ) {
				if (! class_exists( $classname ) ) continue;
				$class = $classname;
				break;
			}
			
			if ( $class == null ) {
				// Error trapping
				return null;
			}
			
			$instance[$serialize] = new $classname();
		}
	
		return $instance[$serialize];
	}
	
	
	/**
	 * **********************************************************************
	 * SIMPLE METHODS
	 * Used for quick and easy curl calls with a single line.
	 * **********************************************************************
	 */
	
	
	/**
	 * Simple call method
	 * @access		public
	 * @version		@fileVers@
	 * @version		1.0.10		- Options weren't being passed along for get calls
	 * @param		string		- $method: the call method to perform
	 * @param		string		- $url: the url to call with curl
	 * @param		array		- $params: any variables / parameters to post/get with
	 * @param		array		- $options: any options to set to the curl handler
	 *
	 * @return		result of execution
	 * @since		1.0.0
	 */
	public function _simple_call($method, $url, $params = array(), $options = array())
	{
		// Get acts differently, as it doesnt accept parameters in the same way
		if ($method === 'get') {
			// If a URL is provided, create new session
			$this->create($url.($params ? '?'.http_build_query($params) : ''));
			
			// Be sure to pass options alongs
			if (! empty( $options ) ) {
				$this->options( $options );
			}
		}
		else {
			// If a URL is provided, create new session
			$this->create($url);
			$this->{$method}($params, $options );
		}
	
		return $this->execute();
	}
	
	
	/**
	 * Simple FTP get
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $url: the url to call for
	 * @param		string		- $file_path: the remote file path to get
	 * @param		string		- $username: the username to use for logging into the FTP server
	 * @param		string		- $password: the password to use for logging into the FTP server
	 *
	 * @return		result of the ftp execution
	 * @since		1.0.0
	 */
	public function simple_ftp_get($url, $file_path, $username = '', $password = '')
	{
		// If there is no ftp:// or any protocol entered, add ftp://
		if ( ! preg_match('!^(ftp|sftp)://! i', $url)) {
			$url = 'ftp://' . $url;
		}
	
		// Use an FTP login
		if ($username != '') {
			$auth_string = $username;
				
			if ($password != '') {
				$auth_string .= ':' . $password;
			}
				
			// Add the user auth string after the protocol
			$url = str_replace('://', '://' . $auth_string . '@', $url);
		}
	
		// Add the filepath
		$url .= $file_path;
	
		$this->option(CURLOPT_BINARYTRANSFER, TRUE);
		$this->option(CURLOPT_VERBOSE, TRUE);
	
		return $this->execute();
	}
	
	
	/**
	 * **********************************************************************
	 * ADVANCED METHODS
	 * Can be used to create more complex requests.
	 * **********************************************************************
	 */
	
	/**
	 * Sets the required items for a post using curl
	 * @access		public
	 * @version		@fileVers@
	 * @param		varies		- $params: the parameters to post
	 * @param		array		- $options: the options to use for curl handler
	 *
	 * @since		3.0.0
	 */
	public function post($params = array(), $options = array())
	{
		$this->debugpost	= $params;
	
		// If its an array (instead of a query string) then format it correctly
		if (is_array($params)) {
			$params = http_build_query($params, NULL, '&');
		}
	
		// Add in the specific options provided
		$this->options($options);
		$this->http_method('post');
	
		$this->option(CURLOPT_POST, TRUE);
		$this->option(CURLOPT_POSTFIELDS, $params);
	}
	
	
	/**
	 * Sets the required items for a put using curl
	 * @access		public
	 * @version		@fileVers@
	 * @param		varies		- $params: the parameters to put
	 * @param		array		- $options: the options to use for curl handler
	 *
	 * @since		3.0.0
	 */
	public function put($params = array(), $options = array())
	{
		// If its an array (instead of a query string) then format it correctly
		if (is_array($params)) {
			$params = http_build_query($params, NULL, '&');
		}
	
		// Add in the specific options provided
		$this->options($options);
	
		$this->http_method('put');
		$this->option(CURLOPT_POSTFIELDS, $params);
	
		$this->option(CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
	}
	
	
	/**
	 * Performs a delete through the curl handler
	 * @access		public
	 * @version		@fileVers@
	 * @param		varies		- $params: the parameters to use for execution
	 * @param		array		- $options: the options for the curl handler
	 *
	 * @since		3.0.0
	 */
	public function delete($params, $options = array())
	{
		// If its an array (instead of a query string) then format it correctly
		if (is_array($params)) {
			$params = http_build_query($params, NULL, '&');
		}
	
		// Add in the specific options provided
		$this->options($options);
		$this->http_method('delete');
		$this->option(CURLOPT_POSTFIELDS, $params);
	}
	
	
	/**
	 * Sets the cookeis for the curl handler
	 * @access		public
	 * @version		@fileVers@
	 * @param		varies		- $params: the cookie parameters to use
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function set_cookies($params = array())
	{
		if (is_array($params)) {
			$params = http_build_query($params, NULL, '&');
		}
	
		$this->option(CURLOPT_COOKIE, $params);
		return $this;
	}
	
	
	/**
	 * Tests to see if there are errors
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string of error message or false on no error
	 * @since		3.0.0
	 */
	public function has_errors()
	{
		return ( $this->error_code != NULL ? $this->error_string : false );
	}
	
	
	/**
	 * Sets an http header
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $header: the header type to use
	 * @param		string		- $content: the content to set the header to
	 *
	 * @since		3.0.0
	 */
	public function http_header($header, $content = NULL)
	{
		$this->headers[] = $content ? $header . ': ' . $content : $header;
	}
	
	
	/**
	 * Sets the http method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $method: the setting to use
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function http_method($method)
	{
		$this->options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
		return $this;
	}
	
	
	/**
	 * Create http login option fields
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $username: the username to use
	 * @param		string		- $password: the password to use
	 * @param		string		- $type: the authentication type to set
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function http_login($username = '', $password = '', $type = 'any')
	{
		$this->option(CURLOPT_HTTPAUTH, constant('CURLAUTH_' . strtoupper($type)));
		$this->option(CURLOPT_USERPWD, $username . ':' . $password);
		return $this;
	}
	
	
	/**
	 * Sets proxy options for the curl handler
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $url: the url to use as the proxy server
	 * @param		integer		- $port: the port on the proxy server to connect through
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function proxy($url = '', $port = 80)
	{
		$this->option(CURLOPT_HTTPPROXYTUNNEL, TRUE);
		$this->option(CURLOPT_PROXY, $url . ':' . $port);
		return $this;
	}
	
	
	/**
	 * Sets the login for a proxy server for the curl handler
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $username: the username to use
	 * @param		string		- $password: the password to use
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function proxy_login($username = '', $password = '')
	{
		$this->option(CURLOPT_PROXYUSERPWD, $username . ':' . $password);
		return $this;
	}
	
	
	/**
	 * Sets the required items for an ssl connection
	 * @access		public
	 * @version		@fileVers@
	 * @param		boolean		- $verify_peer: true to verify peer
	 * @param		integer		- $verify_host: the verify host integer setting for the curl handler
	 * @param		string		- $path_to_cert: the path to the certificate if set
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function ssl($verify_peer = TRUE, $verify_host = 2, $path_to_cert = NULL)
	{
		if ($verify_peer)
		{
			$this->option(CURLOPT_SSL_VERIFYPEER, TRUE);
			$this->option(CURLOPT_SSL_VERIFYHOST, $verify_host);
			$this->option(CURLOPT_CAINFO, $path_to_cert);
		}
		else {
			$this->option(CURLOPT_SSL_VERIFYPEER, FALSE);
			$this->option(CURLOPT_SSL_VERIFYHOST, 0);
			$this->option(CURLOPT_CAINFO, null );
		}
	
		return $this;
	}
	
	
	/**
	 * Sets an array of options to the curl handler options
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: array to set
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function options($options = array())
	{
		// Merge options in with the rest - done as array_merge() does not overwrite numeric keys
		foreach ($options as $option_code => $option_value) {
			$this->option($option_code, $option_value);
		}
	
		// Set all options provided
		curl_setopt_array($this->session, $this->options);
	
		return $this;
	}
	
	
	/**
	 * Sets an individual option code and value
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $code: the curl option to set
	 * @param		varies		- $value: the value to set the code to
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function option($code, $value)
	{
		if (is_string($code) && !is_numeric($code)) {
			$code = constant('CURLOPT_' . strtoupper($code));
		}
	
		$this->options[$code] = $value;
		return $this;
	}
	
	
	/**
	 * Creates a new curl handler session and resets common items
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $url: the url to use for the curl handler
	 *
	 * @return		instance of this object
	 * @since		3.0.0
	 */
	public function create($url)
	{
		// If no a protocol in URL, assume its a CI link
		if ( ! preg_match('!^\w+://! i', $url)) {
			return false;
		}
	
		$this->debugresponse	= null;
		$this->debugmethod		= null;
		$this->debugpost		= null;
		$this->error_code		= NULL;
		$this->error_string		= '';
		$this->url				= $url;
		$this->session			= curl_init($this->url);
	
		// If we are using an SSL URL - set the appropriate options
		if ( preg_match( '!^https://! i', $url ) ) {
			$this->ssl( false );
		}
	
		return $this;
	}
	
	
	/**
	 * Executes the actual curl request
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		response or false on error
	 * @since		3.0.0
	 */
	public function execute()
	{
		// Set two default options, and merge any extra ones in
		if ( ! isset($this->options[CURLOPT_TIMEOUT])) {
			$this->options[CURLOPT_TIMEOUT] = 30;
		}
	
		if ( ! isset($this->options[CURLOPT_RETURNTRANSFER])) {
			$this->options[CURLOPT_RETURNTRANSFER] = TRUE;
		}
		if ( ! isset($this->options[CURLOPT_FAILONERROR])) {
			$this->options[CURLOPT_FAILONERROR] = TRUE;
		}
		
		// Test for redirect capabilities
		if ( ! ini_get('safe_mode') && !ini_get('open_basedir')) {
			$checkforredirects	=
			$origredirsetting	=	false;
			if ( ! isset($this->options[CURLOPT_FOLLOWLOCATION])) {
				$this->options[CURLOPT_FOLLOWLOCATION] = TRUE;
			}
		}
		// We CANT redirect with curl so we must search the response for redirects
		else {
			$checkforredirects	=	true;
			$origredirsetting	=	( isset( $this->options[CURLOPT_HEADER] ) ? $this->options[CURLOPT_HEADER] : false );
			$this->options[CURLOPT_HEADER] = TRUE;
		}
	
		if ( ! empty($this->headers)) {
			$this->option(CURLOPT_HTTPHEADER, $this->headers);
		}
		
		// Assume we are GETTING 
		if (! isset( $this->options[CURLOPT_CUSTOMREQUEST] ) ) {
			$this->option( CURLOPT_CUSTOMREQUEST, 'GET' );
		}
		
		$this->options();
	
		// Added output buffering
		ob_start();
		// Execute the request & and hide all output
		$this->response = curl_exec($this->session);
		$this->info = curl_getinfo($this->session);
		ob_end_clean();
	
		// Request failed
		if ( $this->response === FALSE && $this->count == 0 && $this->info['http_code'] == 500 ) {
			$this->count++;
			return $this->execute();
		}
		else if ($this->response === FALSE) {
			$this->error_code = curl_errno($this->session);
			$this->error_string = curl_error($this->session) . ' [' . $this->url .']';
				
			curl_close($this->session);
			$this->set_defaults();
				
			return FALSE;
		}
		else if ( $checkforredirects && ( $this->info['http_code'] == 301 || $this->info['http_code'] == 302 || $this->info['http_code'] == 303 ) ) {
			$parts		=	explode( "\r\n\r\n", $this->response );
			$hdrlines	=	explode( "\r\n", $parts[0] );
			$url		=	null;
			foreach ( $hdrlines as $hdrline ) {
				if ( strpos( $hdrline, 'Location: ' ) === false ) continue;
				$url	=	str_replace( 'Location: ', '', $hdrline );
				break;
			}
			
			if ( $this->count > 4 ) {
				$this->count--;
				$optns	=	$this->options;
				$optns['Safe Mode or Open Basedir Enabled'] = ( $checkforredirects === true ? 'Yes' : 'No' );
				$optns['Original HEAD Setting']	=	( $origredirsetting ? 'Yes' : 'No' );
				$this->debugoptions		=	self :: translateOptions( $optns );
				$this->debugresponse	= $this->response;
				$this->debugmethod		= $this->options[CURLOPT_CUSTOMREQUEST];
				$this->debugpost		= ( $this->debugmethod == "POST" ? $this->debugpost : array() );
				$response = $this->response;
				$this->set_defaults();
				return false;
			}
			
			// We'll create a new instance of curl for this
			$method	=	strtolower( $this->options[CURLOPT_CUSTOMREQUEST] );
			$hdrs	=	$this->headers;
			$optns	=	$this->options;
			
			$curl	=	dunloader( 'curl', false );
			$curl->create( $url );
			
			if ( $method == 'get' ) {
				$curl->http_method( 'get' );
				$curl->options( $this->options );
			}
			else {
				$curl->$method( $this->debugpost, $this->options );
			}
			
			$curl->count	=	$this->count + 1;
			return $curl->execute();
		}
		
		// Catch requests that aren't looking for the header but we had to add it on
		if ( $checkforredirects && ! $origredirsetting ) {
			$parts	=	explode( "\r\n\r\n", $this->response, 2 );
			$this->response	=	array_pop( $parts );
		}
		
		// Request successful
		curl_close($this->session);
		$optns	=	$this->options;
		$optns['Safe Mode or Open Basedir Enabled'] = ( $checkforredirects === true ? 'Yes' : 'No' );
		$optns['Original HEAD Setting']	=	( $origredirsetting ? 'Yes' : 'No' );
		$this->debugoptions		=	self :: translateOptions( $optns );
		$this->debugresponse	= $this->response;
		$this->debugmethod		= $this->options[CURLOPT_CUSTOMREQUEST];
		$this->debugpost		= ( $this->debugmethod == "POST" ? $this->debugpost : array() );
		$response = $this->response;
		$this->set_defaults();
		return $response;
	}
	
	
	/**
	 * Checks to see if curl is actually enabled
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean true if curl is enabled
	 * @since		3.0.0
	 */
	public function is_enabled()
	{
		return function_exists('curl_init');
	}
	
	
	/**
	 * Outputs the debugging screen
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing debug information
	 * @since		3.0.0
	 */
	public function debug()
	{
		echo "=============================================<br/>\n";
		echo "<h2>CURL Test</h2>\n";
		echo "=============================================<br/>\n";
		echo "<h3>Response</h3>\n";
		echo "<code>" . nl2br(htmlentities($this->debugresponse)) . "</code><br/>\n\n";
	
		if ($this->error_string)
		{
			echo "=============================================<br/>\n";
			echo "<h3>Errors</h3>";
			echo "<strong>Code:</strong> " . $this->error_code . "<br/>\n";
			echo "<strong>Message:</strong> " . $this->error_string . "<br/>\n";
		}
	
		echo "=============================================<br/>\n";
		echo "<h3>Info</h3>";
		echo "<pre>";
		print_r($this->info);
		echo "</pre>";
	
		if ($this->debugmethod == "POST" )
		{
			echo "=============================================<br/>\n";
			echo "<h3>Posted Variables</h3>";
			echo "<pre>";
			print_r($this->debugpost);
			echo "</pre>";
		}
	}
	
	
	/**
	 * Assembles an array of request options for debugging
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array
	 * @since		3.0.0
	 */
	public function debug_request()
	{
		return array( 'url' => $this->url );
	}
	
	
	/**
	 * Sets the default values when new sessions are created
	 * @access		private
	 * @version		@fileVers@
	 *
	 * @since		3.0.0
	 */
	private function set_defaults()
	{
		$this->response = '';
		$this->headers = array();
		$this->options = array();
		$this->session = NULL;
	}
	
	
	/**
	 * Translates the options array into something usable
	 * @static
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		$options		The array of options used to curl
	 *
	 * @return		array
	 * @since		1.2.2
	 */
	private static function translateOptions( $options = array() )
	{
		$data	=	array();
		$names	=	self :: xCurlOpts();
		
		foreach ( $options as $key => $setting ) {
		
			if ( isset( $names[$key] ) ) {
				$name	=	$names[$key];
			}
			else {
				$name	=	$key;
			}
			
			if ( $setting === true || $setting == '1' ) {
				$value	=	'true';
			}
			else if ( $setting === false || $setting == '0' ) {
				$value	=	'false';
			}
			else {
				$value	=	$setting;
			}
			
			$data[$name]	=	$value;
		}
		
		return $data;
	}
	
	
	/**
	 * Stores our array of curloptions for translation
	 * @static
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		array 
	 * @since		1.2.2
	 */
	private static function xCurlOpts()
	{
		$items	=	array(
				'CURLAUTH_ANY',
				'CURLAUTH_ANYSAFE',
				'CURLINFO_HEADER_OUT',
				'CURLOPT_AUTOREFERER',
				'CURLOPT_BINARYTRANSFER',
				'CURLOPT_BUFFERSIZE',
				'CURLOPT_CAINFO',
				'CURLOPT_CAPATH',
				'CURLOPT_CERTINFO',
				'CURLOPT_CLOSEPOLICY',
				'CURLOPT_CONNECT_ONLY',
				'CURLOPT_CONNECTTIMEOUT',
				'CURLOPT_CONNECTTIMEOUT_MS',
				'CURLOPT_COOKIE',
				'CURLOPT_COOKIEFILE',
				'CURLOPT_COOKIEJAR',
				'CURLOPT_COOKIESESSION',
				'CURLOPT_CRLF',
				'CURLOPT_CUSTOMREQUEST',
				'CURLOPT_DNS_CACHE_TIMEOUT',
				'CURLOPT_DNS_USE_GLOBAL_CACHE',
				'CURLOPT_EGDSOCKET',
				'CURLOPT_ENCODING',
				'CURLOPT_FAILONERROR',
				'CURLOPT_FILE',
				'CURLOPT_FILETIME',
				'CURLOPT_FOLLOWLOCATION',
				'CURLOPT_FORBID_REUSE',
				'CURLOPT_FRESH_CONNECT',
				'CURLOPT_FTP_CREATE_MISSING_DIRS',
				'CURLOPT_FTP_USE_EPRT',
				'CURLOPT_FTP_USE_EPSV',
				'CURLOPT_FTPAPPEND',
				'CURLOPT_FTPASCII',
				'CURLOPT_FTPLISTONLY',
				'CURLOPT_FTPPORT',
				'CURLOPT_FTPSSLAUTH',
				'CURLOPT_HEADER',
				'CURLOPT_HEADERFUNCTION',
				'CURLOPT_HTTP_VERSION',
				'CURLOPT_HTTP200ALIASES',
				'CURLOPT_HTTPAUTH',
				'CURLOPT_HTTPGET',
				'CURLOPT_HTTPHEADER',
				'CURLOPT_HTTPPROXYTUNNEL',
				'CURLOPT_INFILE',
				'CURLOPT_INFILESIZE',
				'CURLOPT_INTERFACE',
				'CURLOPT_IPRESOLVE',
				'CURLOPT_KEYPASSWD',
				'CURLOPT_KRB4LEVEL',
				'CURLOPT_LOW_SPEED_LIMIT',
				'CURLOPT_LOW_SPEED_TIME',
				'CURLOPT_MAX_RECV_SPEED_LARGE',
				'CURLOPT_MAX_SEND_SPEED_LARGE',
				'CURLOPT_MAXCONNECTS',
				'CURLOPT_MAXREDIRS',
				'CURLOPT_MUTE',
				'CURLOPT_NETRC',
				'CURLOPT_NOBODY',
				'CURLOPT_NOPROGRESS',
				'CURLOPT_NOSIGNAL',
				'CURLOPT_PASSWDFUNCTION',
				'CURLOPT_PORT',
				'CURLOPT_POST',
				'CURLOPT_POSTFIELDS',
				'CURLOPT_POSTQUOTE',
				'CURLOPT_PROGRESSFUNCTION',
				'CURLOPT_PROTOCOLS',
				'CURLOPT_PROXY',
				'CURLOPT_PROXYAUTH',
				'CURLOPT_PROXYPORT',
				'CURLOPT_PROXYTYPE',
				'CURLOPT_PROXYUSERPWD',
				'CURLOPT_PUT',
				'CURLOPT_QUOTE',
				'CURLOPT_RANDOM_FILE',
				'CURLOPT_RANGE',
				'CURLOPT_READFUNCTION',
				'CURLOPT_REDIR_PROTOCOLS',
				'CURLOPT_REFERER',
				'CURLOPT_RESUME_FROM',
				'CURLOPT_RETURNTRANSFER',
				'CURLOPT_SHARE',
				'CURLOPT_SSH_AUTH_TYPES',
				'CURLOPT_SSH_HOST_PUBLIC_KEY_MD5',
				'CURLOPT_SSH_PRIVATE_KEYFILE',
				'CURLOPT_SSH_PUBLIC_KEYFILE',
				'CURLOPT_SSL_CIPHER_LIST',
				'CURLOPT_SSL_VERIFYHOST',
				'CURLOPT_SSL_VERIFYPEER',
				'CURLOPT_SSLCERT',
				'CURLOPT_SSLCERTPASSWD',
				'CURLOPT_SSLCERTTYPE',
				'CURLOPT_SSLENGINE',
				'CURLOPT_SSLENGINE_DEFAULT',
				'CURLOPT_SSLKEY',
				'CURLOPT_SSLKEYPASSWD',
				'CURLOPT_SSLKEYTYPE',
				'CURLOPT_SSLVERSION',
				'CURLOPT_STDERR',
				'CURLOPT_TIMECONDITION',
				'CURLOPT_TIMEOUT',
				'CURLOPT_TIMEOUT_MS',
				'CURLOPT_TIMEVALUE',
				'CURLOPT_TRANSFERTEXT',
				'CURLOPT_UNRESTRICTED_AUTH',
				'CURLOPT_UPLOAD',
				'CURLOPT_URL',
				'CURLOPT_USERAGENT',
				'CURLOPT_USERPWD',
				'CURLOPT_VERBOSE',
				'CURLOPT_WRITEFUNCTION',
				'CURLOPT_WRITEHEADER',
		);
		
		$data	=	array();
		foreach ( $items as $item ) {
			if ( defined( $item ) ) {
				$data[constant( $item )] = $item;
			}
		}
		
		return $data;
	}
}