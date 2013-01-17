<?php


/**
 * WhmcsDunInput Object
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.3
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
	 * @param		array		- $data: if overloaded can be passed data
	 * 
	 * @since		1.0.3
	 */
	protected function load( $data = array() )
	{
		$get = $post = $request = array();
		
		if ( version_compare( DUN_ENV_VERSION, '5.1', 'ge' ) ) {
			global $whmcs;
			$post	= $whmcs->input;
			$request= $whmcs->input;
		}
		else {
			$get	= $GLOBALS['_GET'];
			$post	= $GLOBALS['_POST'];
			$request= $GLOBALS['_REQUEST'];
		}
		
		$data	= array_merge( array( 'get' => $get, 'post' => $post, 'request' => $request ), $data );
		
		parent :: load( $data );
	}
}
