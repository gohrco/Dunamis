<?php
/**
 * Dunamis Framework
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
 * Dunamis Input Handler
 * @desc		This is the input handler for the Dunamis Framework Plugin
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class BlestaDunInput extends DunInput
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.3.0
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
	 * @param		array		- $data: if overloaded can be passed data
	 * 
	 * @since		1.3.0
	 */
	protected function load( $data = array() )
	{
		$get		= $post = $request = array();
		
		$get		= $GLOBALS['_GET'];
		$post		= $GLOBALS['_POST'];
		$request	= $GLOBALS['_REQUEST'];
		$server		=	$GLOBALS['_SERVER'];
		
		$data	= array_merge( array( 'get' => $get, 'post' => $post, 'request' => $request, 'server' => $server ), $data );
		
		parent :: load( $data );
	}
}
