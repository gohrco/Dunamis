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
 * Dunamis Input handler for WHMCS
 * @desc		This interacts with WHMCS' input handler / variables for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunInput extends DunInput
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		parent :: __construct( $options );
		$this->load();
	}
	
	
	/**
	 * Method to load the input into the object
	 * @access		protected
	 * @version		@fileVers@
	 * @version		1.2.0		- Oct 2013: correction for PHP 5.2 and WHMCS 5.2+ issues
	 * @param		array		- $data: if overloaded can be passed data
	 * 
	 * @since		1.0.3
	 */
	protected function load( $data = array() )
	{
		$get = $post = $request = array();
		
		if ( version_compare( DUN_ENV_VERSION, '5.2', 'ge' ) ) {
			
			if ( method_exists( 'ReflectionProperty', 'setAccessible' ) ) {
				$ca	= $GLOBALS['whmcs'];
				
				$reflect	=	new ReflectionObject( $ca );
				$property	=	$reflect->getProperty( 'input' );
				$property->setAccessible( true );
				
				$post		=	$property->getValue( $ca );
				$request	=	$property->getValue( $ca );
			}
			else {
				$get	= $GLOBALS['_GET'];
				$post	= $GLOBALS['_POST'];
				$request= $GLOBALS['_REQUEST'];
			}
		}
		else if ( version_compare( DUN_ENV_VERSION, '5.1', 'ge' ) ) {
			global $whmcs;
			$post	= $whmcs->input;
			$request= $whmcs->input;
		}
		else {
			$get	= $GLOBALS['_GET'];
			$post	= $GLOBALS['_POST'];
			$request= $GLOBALS['_REQUEST'];
		}
		
		$server	=	$GLOBALS['_SERVER'];
		
		$data	= array_merge( array( 'get' => $get, 'post' => $post, 'request' => $request, 'server' => $server ), $data );
		
		parent :: load( $data );
	}
	
	
	/**
	 * Method for setting a variable to the input handler
	 * @TODO:		Implement variable setting for Dunamis Input Handler [WHMCS]
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $name: the name of the variable to set
	 * @param		mixed		- $value: the value to set
	 * @param		string		- $hash: the request method to use
	 * @param		boolean		- $overwrite: indicates we should overwrite existing
	 *
	 * @return		mixed previous variable
	 * @since		1.1.0
	 */
	public function setVar( $name, $value, $hash = 'request', $overwrite = true )
	{
		// First lets load it into our Dunamis object
		$src	=	$this->src;
		
		if ( isset( $src[$hash] ) ) {
			$src[$hash][$name]	=	$value;
		}
		
		$src['request'][$name]	=	$value;
		
		parent :: load( $src );
		
		
		
		return true;
		
		// Set it to our object first
		$data	=	array( $hash => array( $name => $value ) );
		
		if ( $hash != 'request' ) {
			$data['request']	=	array( 'request' => array( $name, $value ) );
		}
		
		parent :: load( $data );
		
		
		// Grab our global WHMCS object
		global $whmcs;
		
		// Set the user data into the input handler for WHMCS
		if ( version_compare( DUN_ENV_VERSION, '6.0', 'ge' ) ) {
			if ( is_a( $whmcs, 'WHMCS\Application' ) ) {
				$whmcs->replace_input( $data );
			}
		}
		// They changed it for 5.3
		else if ( version_compare( DUN_ENV_VERSION, '5.3', 'ge' ) ) {
			if ( is_a( $whmcs, 'WHMCS_Application' ) ) {
				$whmcs->replace_input( $data );
			}
		}
		// They finally used an object to handle input
		else if ( version_compare( DUN_ENV_VERSION, '5.2', 'ge' ) ) {
			if ( is_a( $whmcs, 'WHMCS_Init' ) ) {
				$whmcs->replace_input( $data );
			}
		}
		else {
				
		}
	}
}
