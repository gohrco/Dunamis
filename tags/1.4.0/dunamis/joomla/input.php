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
 * Dunamis Input class for Joomla
 * @desc		This manages interactions with Joomla!'s Input handler and the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
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
	 * Method to retrieve a variable from the object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $item: the variable to get
	 * @param		mixed		- $default: if not there we want this value back
	 * @param		string		- $src: the location (get|post|request)
	 * @param		string		- $filter: how we want to filter (many)
	 * 
	 * @return		mixed value
	 * @since		1.1.0
	 * @see			DunInput::getVar()
	 */
	public function getVar( $var, $default = null, $filter = 'none', $hash = 'default', $mask = 0 )
	{
		if ( version_compare( JVERSION, '1.7.1', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			if ( $hash == 'default' ) {
				return $app->input->get( $var, $default, $filter );
			}
			else {
				return $app->input->$hash->get( $var, $default, $filter );
			}
		}
		else {
			$value	= JRequest :: getVar( $var, $default, $hash, $filter, $mask );
			// If we are resetting pw on front end, post is empty for some reason
			if ( empty( $value ) && $var == 'post' ) $value = JRequest::get( 'post' );
			return $value;
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
		$data	=	array( 'get' => array(), 'post' => array(), 'request' => array(), 'server' => array() );
		
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
	
	
	/**
	 * Method for setting a variable to the input handler
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
		// Set it to our object first
		$data	=	array( $hash => array( $name => $value ) );
		parent :: load( $data );
		
		if ( version_compare( DUN_ENV_VERSION, '3.0', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			$prev	=   $app->input->get( $name, $value );
			$app->input->set( $name, $value );
			return $prev;
		}
		else if ( version_compare( DUN_ENV_VERSION, '1.7.1', 'ge' ) ) {
			$app	= & JFactory :: getApplication();
			$prev	=   $app->get( $name );
			$app->input->set( $name, $value );
			return $prev;
		}
		else {
			return JRequest :: setVar( $name, $value, $hash, $overwrite );
		}
	}
}
