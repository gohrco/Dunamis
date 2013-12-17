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
}
