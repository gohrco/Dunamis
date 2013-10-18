<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Dunamis Core Updates File
 * This is the core Updates handler of the Dunamis Framework
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
 * Dunamis Updates class handler
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.10
 */
class DunUpdates extends DunObject
{
	protected $_cainfo		=	null;		// Stores cacert location
	protected $_error		=	null;		// Stores last error (string)
	protected $_info		=	array();	// Stores the relevant info on last call
	protected $_response	=	null;		// Stores the last response
	protected $_target		=	null;		// When downloading and storing this is the path/filename to store to
	protected $_url			=	null;		// Stores default / intended URL if not specified in call
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: anything we want to set
	 * 
	 * @since		1.0.10
	 */
	public function __construct( $options = array() )
	{
		$options	=	$this->setProperties( array( 'target', 'url', 'cainfo' ), $options );
		
		if ( $this->getCainfo() == null ) {
			$this->setCainfo( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'cacert.pem' );
		}
		
		return $options;
	}
	
	
	/**
	 * Getter / Setter / Haser function
	 * @desc		Use by calling getUrl() or setUrl('value') to get/set $this->_url
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $name: the method invoked
	 * @param		mixed		- $arguments: any arguments passed along
	 *
	 * @return		mixed
	 * @since		1.0.10
	 */
	public function __call( $name, $arguments )
	{
		if ( strpos( $name, 'get' ) !== false && strpos( $name, 'get' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^get#", '', $name ) );
			return $this->$var;
		}
		
		if ( strpos( $name, 'set' ) !== false && strpos( $name, 'set' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^set#", '', $name ) );
			$value		=	array_shift( $arguments );
			$this->$var	=	$value;
			return $this;
		}
		
		if ( strpos( $name, 'has' ) !== false && strpos( $name, 'has' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^has#", '', $name ) );
			$value	=	(bool) ( isset( $this->$var ) && ! empty( $this->$var ) );
			return $value;
		}
	}
	
	
	/**
	 * Method for downloading and returning the response from the desired URL
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $url: the URL to get
	 * @param		array		- $post: any variables to post
	 * @param		array		- $options: any headers / curloptions to set
	 *
	 * @return		varies response
	 * @since		1.0.10
	 */
	public function downloadAndReturn( $url = null, $post = array(), $options = array() )
	{
		$adapters	=	$this->getAdapters();
		$result		= false;
		
		if ( $url == null ) $url = $this->getUrl();
		
		while (! empty( $adapters ) && ( $result === false ) ) {
			$method = '_get' . ucfirst( array_shift( $adapters ) );
			$result	= $this->$method( $url, $post, $options, false );
		}
		
		return $result;
	}
	
	
	/**
	 * Method to download and store a retrieved item
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $url: the URL to get
	 * @param		string		- $target: the path/filename to store to
	 * @param		array		- $post: any variables to post
	 * @param		array		- $options: any headers / curloptions to set
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function downloadAndStore( $url = null, $target = null, $post = array(), $options = array() )
	{
		if ( $url == null )		$url	=	$this->getUrl();
		if ( $target == null )	$target	=	$this->getTarget();
		
		// We must have them both
		if (! $url || ! $target ) {
			$this->setError( "URL or target empty" );
			return false;
		}
		
		if ( file_exists( $target ) ) {
			if (! @unlink( $target ) ) {
				$this->setError( "Unable to delete pre-existing target file" );
				return false;
			}
		}
		
		$fp			=	@fopen( $target, 'wb' );
		$result		=	false;
		
		if ( $fp !== false ) {
			$adapters	=	$this->getAdapters();
			
			while (! empty( $adapters ) && ( $result === false ) ) {
				$method	=	'_get' . ucfirst( array_shift( $adapters ) );
				$result	=	$this->$method( $url, $post, $options, $fp );
				
				// Check if we have a download
				if ( $result === true ) {
					// The download is complete, close the file pointer
					@fclose( $fp );
						
					// If the filesize is not at least 1 byte, we consider it failed.
					clearstatcache();
					$filesize = @filesize( $target );
						
					if ( $filesize <= 0 ) {
						$result	= false;
						$fp		= @fopen($target, 'wb');
					}
				}
			}
				
			// If we have no download, close the file pointer
			if ( $result === false ) {
				@fclose( $fp );
			}
		}
		
		if ( $result === false ) {
			// Delete the target file if it exists
			if ( file_exists( $target ) ) {
				@unlink( $target );
			}
			
			$this->setError( 'Unable to retrieve download' );
		}
		
		return $result;
	}
	
	
	/**
	 * Method for gathering available adapters
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $data: permits us to specify alternative adapters by submodules (needs to be an array)
	 *
	 * @return		array
	 * @since		1.0.10
	 */
	public function getAdapters( $data = array() )
	{
		// It better be an array or it gets clobbered
		if (! is_array( $data ) ) $data = array();
		
		if ( $this->_hasCurl() )	$data[]	=	'curl';
		if ( $this->_hasFopen() )	$data[]	=	'fopen';
		
		return $data;
	}
	
	
	/**
	 * Method for getting download through Curl
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $url: the URL to retrieve
	 * @param		array		- $post: variables to post to the URL
	 * @param		array		- $options: any CURL options to set
	 * @param		resource	- $store: if we want to store this locally then we need a file resource, else false
	 *
	 * @return		mixed
	 * @since		1.0.10
	 */
	private function _getCurl( $url = null, $post = array(), $options = array(), $store = false )
	{
		// Ensure we have a URL
		if ( $url == null ) $url = $this->getUrl();
		
		// See what method to use
		$method	=	( empty( $post ) ? 'get' : 'post' );
		
		// Set some default options just in case
		if (! isset( $options['CAINFO'] ) )			$options['CAINFO']			= $this->getCainfo();
		if (! isset( $options['HEADER'] ) )			$options['HEADER']			= false;
		if (! isset( $options['RETURNTRANSFER'] ) )	$options['RETURNTRANSFER']	= true;
		if (! isset( $options['AUTOREFERER'] ) )	$options['AUTOREFERER']		= true;
		if (! isset( $options['FAILONERROR'] ) )	$options['FAILONERROR']		= true;
		if (! isset( $options['CONNECTTIMEOUT'] ) )	$options['CONNECTTIMEOUT']	= 10;
		if (! isset( $options['TIMEOUT'] ) )		$options['TIMEOUT']			= 30;
		if (! isset( $options['USERAGENT'] ) )		$options['USERAGENT']		= 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		
		// If we are storing the results
		if ( is_resource( $store ) ) {
			$options['FILE']	=	$store;
		}
		
		$dunoptns	=	array(	'url'			=>	$url,
								'curloptions'	=>	$options,
								'post'			=>	$post
				);
		
		$curl		=	dunloader( 'curl', false, $dunoptns );
		$curl->create( $url );
		
		if( $method == 'post' ) {
			$curl->post( $post, $options );
		}
		else {
			$curl->options( $options );
		}
		
		// Execute the Curl Call
		$response	=	$curl->execute();
		echo '<pre>'.print_r($curl,1);die();
// 		$restcall	=	'simple_' . $method;
// 		$response	=	$curl->$restcall( $url, $post, $options );
		
		//$this->setResponse( $response );
		$this->setInfo( $curl->info );
		
		if ( ( $error = $curl->has_errors() ) ) {
			$this->setError( $error );
			return false;
		}
		
		return $response;
	}
	
	
	
	/**
	 * Method for getting download through Fopen
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $url: the URL to retrieve
	 * @param		array		- $post: variables to post to the URL
	 * @param		array		- $options: any header options to set
	 * @param		resource	- $store: if we want to store this locally then we need a file resource, else false
	 *
	 * @return		mixed
	 * @since		1.0.10
	 */
	private function _getFopen( $url = null, $post = array(), $options = array(), $store = false )
	{
		$result = false;
		
		// Ensure we have a URL
		if ( $url == null ) $url = $this->getUrl();
		
		// Handle post variables
		if (! empty( $post ) ) {
			$post				=	http_build_query( $post );
			$options['header']	=	"Content-type: application/x-www-form-urlencoded\r\n"
								.	"Content-Length: " . strlen( $post ). "\r\n";
			$options['content']	=	$post;
		}
		
		// Set some default headers
		if (! isset( $options['method'] ) )	$options['method']	= 'POST';
		if (! isset( $options['header'] ) ) $options['header']	= 'Content-type: application/x-www-form-urlencoded';
		
		$context	=	stream_context_create( array( 'http' => $options ) );
		$ih = @fopen( $url, 'r', false, $context );
		
		// Bail if we can't connect
		if (! is_resource( $ih ) ) {
			return $result;
		}
		
		// So we found it... now what?
		$bytes = 0;
		$result = true;
		$return = '';
		
		// bit by bit...
		while (! feof( $ih ) && $result ) {
			
			$contents	=	fread( $ih, 4096 );
			
			// Catch in case we get nothing
			if ( $contents === false ) {
				@fclose( $ih );
				$result = false;
				return $result;
			}
			else {
				$bytes += strlen( $contents );
				
				// If we are storing the file write what we got now
				if ( is_resource( $store ) ) {
					$result = @fwrite( $fp, $contents );
				}
				// We are just sending back what we got not writing...
				else {
					$return .= $contents;
					unset( $contents );
				}
			}
		}
		
		@fclose( $ih );
		
		if ( is_resource( $store ) ) {
			return $result;
		}
		elseif( $result === true ) {
			return $return;
		}
		else {
			return $result;
		}
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.10
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
	
		if (! is_object( $instance ) ) {
			
			$classname	=	'DunUpdates';
			
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunUpdates';
			}
			
			if ( class_exists( $classname ) && defined( 'DUN_ENV' ) ) {
				$instance	= new $classname( $options );
			}
			else {
				$instance	= new self( $options );
			}
		}
	
		return $instance;
	}
	
	
	/**
	 * Method for checking for use of CURL
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.10
	 */
	private function _hasCurl()
	{
		static $result = null;
		
		if ( is_null( $result ) ) {
			$result = function_exists( 'curl_init' );
		}
		
		return $result;
	}
	
	
	/**
	 * Method for checking for use of FOPEN
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		true
	 * @since		1.0.10
	 */
	private function _hasFopen()
	{
		static $result = null;
		
		if ( is_null( $result ) ) {
			// If we are not allowed to use ini_get, we assume that URL fopen is disabled.
			if (! function_exists( 'ini_get' ) ) {
				$result = false;
			}
			else {
				$result = ini_get( 'allow_url_fopen' );
			}
		}
		
		return $result;
	}
	
	
	/**
	 * Method to set properties for an object
	 * @access		protected
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $properties: any properties to cycle through
	 * @param		array		- $options: the options array passed to us
	 *
	 * @return		array
	 * @since		1.0.10
	 */
	protected function setProperties( $properties, $options )
	{
		foreach ( $properties as $item ) {
			if ( isset( $options[$item] ) ) {
				$meth = 'set' . ucfirst( $item );
				$this->$meth( $options[$item] );
				unset( $options[$item] );
			}
		}
		return $options;
	}
}