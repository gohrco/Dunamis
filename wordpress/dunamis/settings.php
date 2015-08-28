<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @projectName@
 * Dunamis Framework - Admin Module Base File
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.5.0
 *
 * @desc       This file is the admin controller
 *
 */


/**
 * Define the Dunamis Framework version here
 */
if (! defined( 'DUN_MOD_DUNAMIS' ) ) define( 'DUN_MOD_DUNAMIS', "@fileVers@" );

/**
 * Admin Module Class for Dunamis Framework
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.5.0
 */
class DunamisSettingsDunModule extends DunamisAdminDunModule
{
	/**
	 * Stores what the action we are using
	 * @access		protected
	 * @var			string
	 * @since		1.5.0
	 */
	protected $action	= 'settings';
	
	/**
	 * Stores the alerts to display back
	 * @access		protected
	 * @var			array
	 * @since		1.5.0
	 */
	protected $alerts	= array( 'error' => array(), 'success' => array(), 'info' => array(), 'block' => array() );
	
	
	/**
	 * Stores any modals to render
	 * @access		protected
	 * @var			array
	 * @since		1.5.0
	 */
	protected $modals	= array();
	
	/**
	 * Stores what the task is for this page
	 * @access		protected
	 * @var			string
	 * @since		1.5.0
	 */
	protected $task	= 'default';
	
	/**
	 * Stores the type of module this is
	 * @access		protected
	 * @var			string
	 * @since		1.5.0
	 */
	protected $type	= 'plugin';
	
	
	/**
	 * Method for handling tasks
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.5.0
	 */
	public function execute()
	{
		switch( $this->task ) :
		case 'save' :
			
			foreach ( $this->getFields() as $k ) {
				$$k	=	( isset( $_POST[$k] ) ? $_POST[$k] : false );
				update_option( 'dunamis_' . $k, $$k );
			}
			
		break;
		endswitch;
	}
	
	
	/**
	 * Method to get an array of settings we use in our application
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		array
	 * @since		1.5.0
	 */
	public function getFields()
	{
		return array(
				'debug',
				'token',
		);
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.5.0
	 */
	public function initialise()
	{
		static $instance = false;
	
		if (! $instance ) {
			$instance	= true;
		}
		
		$input	=	dunloader( 'input', true );
		$task	=	$input->getVar( 'task', 'default' );
		
		if ( $task ) {
			$this->task = $task;
		}
	}
	
	
	/**
	 * Function to render the options page back to user
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.5.0
	 */
	public function render()
	{
		// Permission check
		if (! current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
	
		// In case we are saving...
		$this->execute();
		
		// Grab our option from our database
		$values	=	array();
		foreach ( $this->getFields() as $k ) {
			$values[$k]	=	get_option( 'dunamis_' . $k );
		}
		
		// Build our form
		$form	=	dunloader( 'form', true );
		$form->setValues( $values, 'dunamis.setting-general' );
		$fields	=	$form->loadForm( 'setting-general', 'dunamis' );
	
		// Pull in our view
		ob_start();
		include __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'settings.php';
		$data	=	ob_get_clean();
	
		echo parent :: render( $data );
	}
}