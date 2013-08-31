<?php defined('DUNAMIS') OR exit('No direct script access allowed');


/**
 * WHMCS API class handler
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.10
 */
class WhmcsDunApi extends DunObject
{
	/**
	 * The default character set
	 * @var		string
	 */
	protected $charset	= "UTF-8";
	
	/**
	 * Stores conversion function existance
	 * @var		boolean
	 */
	protected $iconv	= false;
	
	/**
	 * Stores the response type requested
	 * @var		string
	 */
	protected $response	= 'json';
	
	/**
	 * Stores the revision date of this file
	 * @var		string
	 */
	protected $revdate	= '@buildDate@';
	
	/**
	 * The current version of this file
	 * @var		string
	 */
	protected $version = '@fileVers@';
	
	
	/**
	 * Stores the version of WHMCS being run
	 * @var 	string
	 */
	protected $whmcsver	= null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.0.10
	 */
	public function __construct( $options = array() )
	{
		parent :: __construct( $options );
		
		$config	=	dunloader( 'config', true );
		$input	=	dunloader( 'input', true );
		
		$this->charset	=	$config->get( 'Charset' );
		$this->response	=	$input->getVar( 'responsetype', 'json' );
		$this->whmcsver	=	$config->get( 'Version' );
		$this->iconv	=	( function_exists( "iconv" ) ? ( $this->charset == "UTF-8" ? false : true ) : false );
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
			$instance	=	new WhmcsDunApi( $options );
		}
		
		return $instance;
	}
	
	
	/**
	 * Method for building the response
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		void
	 * @since		1.0.10
	 */
	public function response()
	{
		switch ( $this->response ) :
		case 'nvp' :
			$data	=	$this->_buildNvp();
			break;
		case 'xml' :
			$data	=	$this->_buildXml();
			break;
		case 'json':
		default:
			$data	=	$this->_buildJson();
			break;
		endswitch;
		
		return $data;
	}
	
	
	/**
	 * Method for setting the data to the object
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		mixed		- $data: the data to set
	 *
	 * @since		1.0.10
	 */
	public function setData( $data = array() )
	{
		$data			=	$this->_translit( $data );
		
		if (! is_array( $data ) || ! isset( $data['result'] ) ) {
			$data	=	array( 'result' => 'success', 'data' => $data );
		}
		
		$this->data		=	$data;
	}
	
	
	/**
	 * Method for building the json response
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	private function _buildJson()
	{
		return json_encode( $this->data );
	}
	
	
	/**
	 * Method for building an NVP response back
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $data: the data array to build
	 * @param		string		- $prefix: a prefix to attach for arrayed data
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	private function _buildNvp( $data = null, $prefix = null )
	{
		// If our first time grab our data
		if ( $data == null ) {
			$data = $this->data;
		}
		
		$response	=	null;
		
		foreach ( $data as $k => $v ) {
			if ( is_array( $v ) ) {
				$response .= $this->_buildNvp( $v, $k . '-' );
				continue;
			}
			
			if ( strpos( $response, '=' ) !== false ) {
				$response	.= '&';
			}
			
			$response	.= urlencode( $k ) . '=' . urlencode( $v );
		}
		
		return $response;
	}
	
	
	/**
	 * Method for building the xml response
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	private function _buildXml()
	{
		header( "Content-type: text/xml" );
		
		$data	=	$this->_xmlcdata( $this->data );
		$wvers	=	$this->whmcsver;
		$xml	=	'<?xml version="1.0" encoding="utf-8"?><whmcsapi version="' . $wvers . '">' . $data . "</whmcsapi>";
		
		return $xml;
	}
	
	
	/**
	 * Test for seeing if a string is UTF8 or not
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $Str: the string we are testing
	 *
	 * @return		boolean
	 * @since		1.0.10
	 */
	private function _seems_utf8( $Str )
	{
		for ($i=0; $i<strlen($Str); $i++) {
			if ( ord($Str[$i]) < 0x80 ) continue; # 0bbbbbbb
			elseif ( (ord($Str[$i]) & 0xE0) == 0xC0 ) $n=1; # 110bbbbb
			elseif ( (ord($Str[$i]) & 0xF0) == 0xE0 ) $n=2; # 1110bbbb
			elseif ( (ord($Str[$i]) & 0xF8) == 0xF0 ) $n=3; # 11110bbb
			elseif ( (ord($Str[$i]) & 0xFC) == 0xF8 ) $n=4; # 111110bb
			elseif ( (ord($Str[$i]) & 0xFE) == 0xFC ) $n=5; # 1111110b
			else return false; # Does not match any model
			
			for ( $j=0; $j<$n; $j++ ) { # n bytes matching 10bbbbbb follow ?
				if ( (++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80) ) {
					return false;
				}
			}
		}
		
		return true;
	}
		
		
	/**
	 * Transliterate data
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		mixed		- $data: the data to translit
	 *
	 * @return		transliterated data
	 * @since		1.0.10
	 */
	private function _translit( $data )
	{
		if ( $this->iconv ) {
			foreach ( $data as $key => $value ) {
				if ( is_array( $value ) ) {
					$value = $this->_translit( $value );
				}
				else {
					$data[$key] = iconv( "{$this->charset}", "UTF-8//TRANSLIT", $value );
				}
			}
		}
		
		return $data;
	}
	
	
	/**
	 * Method to ensure a value is UTF8
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		$str
	 *
	 * @return		utf8 string
	 * @since		1.0.10
	 */
	private function _utf8_ensure( $str )
	{
		if (! function_exists( 'utf8_encode' ) ) return $str;
		return $this->_seems_utf8($str)? $str: utf8_encode($str);
	}
	
	
	
	/**
	 * Method to cleanup xml data
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		mixed		- $data: the data to wrap in cdatas
	 *
	 * @return		mixed
	 * @since		1.0.10
	 */
	private function _xmlcdata( $data )
	{
		// Loop through each data set and add to the xml output
		foreach ($data as $key => $value) {
			if ( is_array ( $value ) ) {
				$xml .= "<{$key}s>" . $this->_xmlcdata( $value ) . "</{$key}s>";
			}
			else {
				$value	= ( $this->iconv ? iconv( "{$this->charset}", "UTF-8//TRANSLIT", $value ) : $value );
				$value  =   $this->_utf8_ensure( $value );
				$xml .= "<{$key}><![CDATA[{$value}]]></{$key}>";
			}
		}
		
		return $xml;
	}
}