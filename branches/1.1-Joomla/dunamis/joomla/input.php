<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Joomla Dunamis Environment File
 * This is the environment handler of the Dunamis Framework
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
 * Joomla Dunamis Input class handler
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.1.0
 */
class JoomlaDunInput extends DunInput
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.1.0
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
	 * @since		1.1.0
	 */
	protected function load( $data = array() )
	{
		$get = $post = $request = array();
		
		$app	= & JFactory :: getApplication();
		$cycle	=	array( 'get' => $_GET, 'post' => $_POST, 'request' => $_REQUEST );
		$data	=	array( 'get' => array(), 'post' => array(), 'request' => array() );
		
		foreach ( $cycle as $k => $v ) {
			foreach ( $v as $f => $trash ) {
				
				if ( version_compare( DUN_ENV_VERSION, '1.7.1', 'ge' ) ) {
					$data[$k][$f] = $app->input->$k->get( $f );
				}
				else {
					$data[$k][$f]	=	JRequest :: getVar( $f, null, $k );
				}
			}
		}
		
		parent :: load( $data );
	}
}
