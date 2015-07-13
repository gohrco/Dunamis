<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @projectName@
 * Dunamis - Default Module Base File
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.4.0
 *
 * @desc       This file is the default controller
 *
 */


/**
 * Default Module Class for J!WHMCS Integrator
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.4.0
 */
class DunamisDefaultDunModule extends DunamisAdminDunModule
{
	/**
	 * Provide means to check for file integrity
	 * @access		protected
	 * @var			string
	 * @since		1.4.0
	 */
	protected $checkstring	=	"@checkString@";
	
	
	/**
	 * Initialise the object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.4.0
	 * @see			IntegratorAdminDunModule :: initialise()
	 */
	public function initialise()
	{
		$this->action = 'default';
		parent :: initialise();
	}
	
	/**
	 * Method to execute tasks
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $task: if we are passing a specific task to do
	 * 
	 * @since		1.4.0
	 */
	public function execute()
	{
		
	}
	
	
	/**
	 * Method to render back the view
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing formatted output
	 * @since		1.4.0
	 */
	public function render( $data = null )
	{
		$doc	= dunloader( 'document', true );
		$doc->addStyleDeclaration( "#dunamis .row .well-small h3 {margin: 0; padding: 0; }" );
		$doc->addStyleDeclaration( "#dunamis .icon-hang {margin-left: -20px; }" );
		
		$data	= $this->buildBody();
		
		return parent :: render( $data );
	}
	
	
	/**
	 * Builds the body of the action
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.4.0
	 */
	public function buildBody()
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
		
		return $data;
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