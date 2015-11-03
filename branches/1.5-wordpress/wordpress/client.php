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
class DunamisClientDunModule extends WordpressDunModule
{
	/**
	 * Stores what the action we are using
	 * @access		protected
	 * @var			string
	 * @since		1.5.0
	 */
	protected $action	= 'default';
	
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
}
