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
 * Dunamis API Response class for Wordpress
 * @desc		This permits a uniform method of API responses in Wordpress through the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Wordpress
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunApiresponse extends DunObject
{
	public $enabled			=	false;
	public $apisignature	=	null;
	public $apitimestamp	=	null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.5.0
	 */
	public function __construct( $vars = array() )
	{
		$errors	=	array();
		
		// We are in a module / API handler
		foreach ( array( 'apisignature', 'apitimestamp' ) as $k ) {
			if (! isset( $vars[$k] ) ) {
				$errors[]	=	sprintf( 'Missing the %s variable', $k );
				continue;
			}
				
			if ( $k != 'apitoken' ) {
				$this->set( $k, $vars[$k] );
			}
		}
		
		// If we have errors bail
		if (! empty( $errors ) ) {
			return $this->set( 'errors', $errors );
		}
		
		// Ensure we can get the token
		$module	=	strtolower( $this->get( 'dun_module' ) );
		$config	=	dunloader( 'config', $module );
		$token	=	is_object( $config ) ? $config->get( $module . '_token' ) : false; 
		
		if (! $token ) {
			$errors[]	=	'Unable to retrieve the token from the module settings';
			return $this->set( 'errors', $errors );
		}
		
		// Test the signature for validity
		$hdrstr		=	strtoupper( $this->get( 'dun_module' ) ) . "APISIGNATURE";
		$input		=	dunloader( 'input', true );
		$hdrsig		=	$input->getVar( 'HTTP_' . $hdrstr, null, 'server' );
		$qrysig		=	$this->get( 'apisignature' );
		
		// Test if our qry and header signatures match first
		if ( $this->_compareSignatures( $hdrsig, $qrysig ) !== true ) {
			$errors[]	=	'The signatures passed to the application do not match one another - aborting connection';
			return $this->set( 'errors', $errors );
		}
		
		// Next lets generate a signature
		$gensig		=	$this->_generateSignature();
		$usesig		=	(string) urldecode( rand( 0, 1 ) == '1' ? $hdrsig : $qrysig );
		
		if ( $this->_compareSignatures( $gensig, $usesig ) !== true ) {
			$errors[]	=	'The signature passed to the application and the one generated do not match one another - aborting connection';
			return $this->set( 'errors', $errors );
		}
		
		// Test the timestamp to ensure recent request
		$gmt		=	new DateTime( null, new DateTimeZone('GMT') );
		$current	=	$gmt->format("U");
		$timestamp	=	$this->get( 'apitimestamp' );
		//$timediff	=	( $config->get( 'debug' ) ? 300 : 45 );
		$timediff	=	45;
		
		// Test the timestamp
		if ( ( $current - $timestamp ) > $timediff ) {
			// The request is older than 2 minutes... something isn't right
			$errors[]	=	'The timestamp is too old you must make another request - aborting connection';
			return $this->set( 'errors', $errors );
		}
		
		// If we have made it this far we must be accepted
		$this->set( 'enabled', true );
	}
	
	
	/**
	 * Handles errors from response handler
	 * @access		public
	 * @version		@fileVers@
	 * @param		string
	 *
	 * @since		1.5.0
	 */
	public function error( $message = null )
	{
		if (! is_array( $message ) ) $message = (array) $message;
		
		$data	=	array(
			'result'	=> 'error',
			'message'	=>	$message,
			'debug'		=>	dunloader( 'debug', true )->renderforApi(),
		);
		
		echo json_encode( $data );
		exit();
	}
	
	
	/**
	 * Getter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being sought
	 * 
	 * @return		mixed value of setting or false
	 * @since		1.5.0
	 */
	public function get( $item )
	{
		if ( $this->$item ) {
			return $this->$item;
		}
		else return false;
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.5.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
				
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunApiresponse';
				$instance	= new $classname( $options );
			}
			else {
				$instance = new self( $options );
			}
		}
	
		return $instance;
	}
	
	
	/**
	 * Response handler
	 * @access		public
	 * @version		@fileVers@
	 * @param		array
	 * 
	 * @since		1.5.0
	 */
	public function respond( $data = array( 'result' => 'error', 'message' => 'Nothing passed to response handler' ) )
	{
		// Seek out our task
		$task		=	$this->getTask();
		
		if (! $task ) $this->error( 'No task was sent to the Dunamis module to handle' );
		
		$path		=	$this->getPath();
		$filename	=	$this->getFilename();
		
		if (! file_exists( $path . $filename ) ) {
			dunloader( 'debug', true )->variable( $path . $filename, 'Path to API' );
			$this->error( 'File not found for task requested - aborting attempt' );
		}
		
		include_once( $path . 'base.php' );
		
		$class	=	$this->getClass();
		if (! class_exists( $class ) ) {
			dunloader( 'debug', true )->variable( $class, 'Base Class Being Sought' );
			$this->error( 'Base class not found to execute request - aborting attempt' );
		}
		
		include_once( $path . $filename );
		$class	=	ucfirst( $task ) . $class;
		
		if (! class_exists( $class ) ) {
			dunloader( 'debug', true )->variable( $class, 'Class Being Sought' );
			$this->error( 'Class not found to execute request - aborting attempt' );
		}
		
		$api	=	new $class();
		$result	=	$api->execute();
		
		// Leave open the possiblity we may want to continue to execute Wordpress
		return $result;
	}
	
	
	/**
	 * Setter method
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the setting being set
	 * @param		mixed		- $value: the value to set
	 * 
	 * @since		1.5.0
	 */
	public function set( $item, $value )
	{
		if ( empty( $item ) ) return;
		$this->$item = $value;
	}
	
	
	/**
	 * Method to compare signatures
	 * @desc		Used to prevent timing attacks
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $a: signature 1
	 * @param		string		- $b: signature 2
	 *
	 * @return		boolean
	 * @since		2.5.0
	 */
	private function _compareSignatures( $a, $b )
	{
		$diff = strlen($a) ^ strlen($b);
	
		for ( $i = 0; $i < strlen($a) && $i < strlen($b); $i++ ) {
			$diff |= ord( $a[$i] ) ^ ord( $b[$i] );
		}
	
		return $diff === 0;
	}
	
	
	private function _getMethod()
	{
		$input	=	dunloader( 'input', true );
		return		strtolower( $input->getVar( 'REQUEST_METHOD', null, 'server' ) );
	}
	
	
	/**
	 * Method to generate a signature for validation
	 * @static
	 * @access		public
	 * @version		@fileVers@ 
	 * @version		2.5.8		Added check for sh404sef
	 * 
	 * @return		string
	 * @since		2.5.0
	 */
	private function _generateSignature()
	{
		$input	=	dunloader( 'input', true );
		$module	=	strtolower( $this->get( 'dun_module' ) );
		$config	=	dunloader( 'config', $module );
		
		$method	=	$this->_getMethod();
		$token	=	$config->get( $module . '_token' );
		$uri	=	clone DunUri :: getInstance( 'SERVER', true );
		$append	=	null;
		
		$uri->delVar( 'apisignature' );
		
		if ( $method == 'post' ) {
			$post	=	$_POST;
			ksort( $post );
		
			foreach ( $post as $k => $v ) {
				if ( $k == 'apisignature' ) continue;
				$append	.=	$k . $input->getVar( $k, null, 'post', 'string' );
			}
		}
		else if ( $method == 'get' || $method == 'put' ) {
			$uri->delVar( 'apisignature' );
		}
		
		return base64_encode( hash_hmac( 'sha256', rawurldecode( $uri->toString() ) . $append, $token, true ) );
	}
}