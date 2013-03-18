<?php defined('DUNAMIS') OR exit('No direct script access allowed');

if (! defined( 'DUN_MOD_DUNAMIS' ) ) define( 'DUN_MOD_DUNAMIS', "@fileVers@" );

/**
 * Dunamis API Class
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.10
 */
class DunamisApiDunModule extends WhmcsDunModule
{
	/**
	 * Stores the data to send back through the API
	 * @access		pritected
	 * @var			mixed
	 * @since		1.0.10
	 */
	protected $data	=	null;
	
	/**
	 * Stores the task to perform
	 * @access		protected
	 * @var			string
	 * @since		1.0.10
	 */
	protected $task	=	'ping';
	
	/**
	 * Stores the type of module this is
	 * @access		protected
	 * @var			string
	 * @since		1.0.10
	 */
	protected $type	= 'addon';
	
	/**
	 * Method for executing the requested task
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		void
	 * @since		1.0.10
	 */
	public function execute()
	{
		$task	=	$this->task;
		
		if ( method_exists( $this, $task ) ) {
			return $this->$task();
		}
		else {
			return $this->ping();
		}
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.10
	 */
	public function initialise()
	{
		$this->area = 'api';
		
		dunloader( 'language', true )->loadLanguage( 'dunamis' );
		dunloader( 'hooks', true )->attachHooks( 'dunamis' );
		
		$this->task	=	dunloader( 'input', true )->getVar( 'task', 'ping' );
	}
	
	
	/**
	 * Method for returning a ping response
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	public function ping()
	{
		return 'pong';
	}
	
	
	/**
	 * Method for returning the version of Dunamis
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	public function version()
	{
		return '@fileVers@';
	}
}