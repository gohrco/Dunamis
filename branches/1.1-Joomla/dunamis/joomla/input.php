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
	 * Method to return what method we are using to view the page
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.1.0
	 */
	public function getMethod()
	{
		if ( version_compare( JVERSION, '1.7.0', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			return strtolower( $app->input->getMethod() );
		}
		else {
			return strtolower( JRequest :: getMethod() );
		}
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
		$cycle	=	array( 'get' => $_GET, 'post' => $_POST, 'request' => $_REQUEST, 'server' => $_SERVER );
		$data	=	array( 'get' => array(), 'post' => array(), 'request' => array() );
		
		foreach ( $cycle as $k => $v ) {
			foreach ( $v as $f => $trash ) {
				
				$t	=	is_array( $trash ) ? 'array' : 'string';
				
				if ( version_compare( DUN_ENV_VERSION, '1.7.1', 'ge' ) ) {
					$data[$k][$f] = $app->input->$k->get( $f, null, $t );
				}
				else {
					$data[$k][$f]	=	JRequest :: getVar( $f, null, $k, $t );
				}
			}
		}
		
		parent :: load( $data );
	}
}
