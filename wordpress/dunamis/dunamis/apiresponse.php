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
class DunamisDunApiresponse extends WordpressDunApiresponse
{
	public $enabled			=	false;
	public $dun_module		=	'Dunamis';
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
		parent :: __construct( $vars );
		
		// Bail if we aren't enabled
		if (! $this->get( 'enabled' ) ) return;
		
		// We must have a task to execute I'm afraid
		$input	=	dunloader( 'input', true );
		$task	=	$input->getVar( 'task', false );
		
		if (! $task ) {
			$this->set( 'errors', array( 'No task was specified for module to execute' ) );
			return $this->set( 'enabled', false );
		}
		
	}
	
	
	/**
	 * Method to get the class name we are using
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.5.0
	 */
	public function getClass()
	{
		return 'DunamisDunApidispatch';
	}
	
	
	/**
	 * Method to get the filename of the task we are seeking
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.5.0
	 */
	public function getFilename()
	{
		return strtolower( $this->getTask() ) . '.php';
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
		static $instance = array();
		
		$serialize	=	serialize( $options );
		
		if (! isset( $instance[$serialize] ) ) {
			$instance[$serialize]	=	new self ( $options );
		}
		
		return $instance[$serialize];
	}
	
	
	/**
	 * Method to get the path from our object for modular capability
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.5.0
	 */
	public function getPath()
	{
		return dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR;
	}
	
	
	/**
	 * Method to get the task from our handler for modular capability
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public function getTask()
	{
		$input	=	dunloader( 'input', true );
		return $input->getVar( 'task', null );
	}
}