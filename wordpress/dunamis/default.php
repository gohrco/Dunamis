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
class DunamisDefaultDunModule extends DunamisAdminDunModule
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
	
	
	/**
	 * Renders our dashboard to our user
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.5.0
	 */
	public function render()
	{
		$input		=	dunloader( 'input', true );
		$task		=	$input->getVar( 'task' );
		
		$data		=	'<div class="row-fluid">'
					.	'	<div class="span12 well">'
					.	'	</div>'
					.	'</div>';
		
		$widgets	=	implode( "", $this->_getWidgets() );
		$data		=	'<div class="row">'
					.	'	<div class="well span8">'
					.			t( 'dunamis.home.subtitle' )
					.			t( 'dunamis.home.body' )
					.	'	</div>'
					.	'	<div class="span4">'
					.	'		' . $widgets
					.	'	</div>'
					.	'</div>';
		
		$data	=	parent :: render( $data );
		echo $data;
	}
	
	
	/**
	 * Method for getting the widgets for the dashboard
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $widget: contains the widget to retrieve
	 *
	 * @return		html formatted string
	 * @since		1.4.0
	 */
	private function _getWidgets( $widget = 'all' )
	{
		// Loop through for all of them
		if ( $widget == 'all' ) {
			$data	=	array();
				
			foreach ( array( 'updates', /*'license', 'likeus' /*'status', * 'updates', 'license', 'likeus'*/ ) as $widg ) {
				$data[$widg]	= $this->_getWidgets( $widg );
			}
				
			return $data;
		}
	
		// We are asking for a specific one...
		$data			=	null;
		$result			=	(object) array( 'status' => null, 'header' => null, 'body' => null );
		$result->header	=	t( 'dunamis.admin.widget.' . $widget . '.header');
		
		switch ( $widget ) {
			case 'updates' :
				$updates	=	dunloader( 'updates', 'dunamis' );
				$version	=	$updates->updatesExist();
				$error		=	$updates->hasError();
	
				$result->header	=	t( 'dunamis.admin.widget.updates.header', '@fileVers@' );
	
				if ( $version ) {
					$result->status = '';
					$result->body	= t( 'dunamis.admin.widget.updates.body.exist', $version );
				}
				else if ( $error ) {
					$result->status = '-danger';
					$result->body	= t( 'dunamis.admin.widget.updates.body.error', $updates->getError() );
				}
				else {
					$result->status = '-success';
					$result->body	= t( 'dunamis.admin.widget.updates.body.none' );
				}
	
				break;
		}
	
		$data	=	'<div class="well well-small alert' . $result->status . '">'
				.	'	<h3>' . $result->header . '</h3>'
				.	'	' . $result->body
				.	'</div>';
	
		return $data;
	}
}
