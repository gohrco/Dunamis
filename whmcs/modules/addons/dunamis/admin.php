<?php defined('DUNAMIS') OR exit('No direct script access allowed');

if (! defined( 'DUN_MOD_DUNAMIS' ) ) define( 'DUN_MOD_DUNAMIS', "@fileVers@" );

/**
 * Dunamis Admin Class
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.0
 */
class DunamisAdminDunModule extends WhmcsDunModule
{
	/**
	 * Stores what the task is for this page
	 * @access		protected
	 * @var			string
	 * @since		1.3.3
	 */
	protected $task	= 'default';
	
	/**
	 * Stores the type of module this is
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $type	= 'addon';
	
	/**
	 * Builds the alerts for display
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.3.3
	 */
	public function buildAlerts()
	{
		$data	= null;
		$check	= array( 'success', 'error', 'block', 'info' );
	
		foreach ( $check as $type ) {
			if ( empty( $this->alerts[$type] ) ) continue;
			$data	.=	'<div class="alert alert-' . $type . '"><h4>' . t( 'dunamis.alert.' . $type ) . '</h4>'
					.	implode( "<br/>", $this->alerts[$type] )
					.	'</div>';
		}
	
		return $data;
	}
	
	
	/**
	 * Builds any modals that are set to the object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		html formatted string
	 * @since		1.3.3
	 */
	public function buildModals()
	{
		if ( empty( $this->modals ) ) return null;
	
		$data	= null;
		foreach ( $this->modals as $modal ) {
			$id	= $modal['id'];
			$btns	=	implode("\n", $modal['buttons'] );
			$data	.=	'<div aria-hidden="true" aria-labelledby="' . $id . 'Label" role="dialog" tabindex="-1" class="modal" id="' . $id . '" style="display: none; ">'
					.	'	<div class="modal-header">'
					.	'		<button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>'
					.	'		<h3 id=' . $id . 'Label">' . $modal['hdr'] .'</h3>'
					.	'	</div>'
					.	'	<div class="modal-body">'
					.	'		<h4>' . $modal['title'] . '</h4>'
					.	'		' . $modal['body']
					.	'	</div>'
					.	'	<div class="modal-footer">'
					.	'		' . $btns
					.	'	</div>'
					.	'</div>';
		}
	
		return $data;
	}
	
	
	/**
	 * Builds the navigation menu
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.3.3
	 */
	public function buildNavigation()
	{
		$uri	=	DunUri :: getInstance( 'SERVER', true );
		$uri->delVars();
		$uri->setVar( 'module', 'dunamis' );
	
		$data		=	'<ul class="nav nav-pills">';
		$actions	=	array( 'default', 'settings', 'updates', 'installer' );
	
		// See if we can test the API
		$config		=	dunloader( 'config', 'dunamis' );
		
		foreach( $actions as $item ) {
			
			if ( $item == $this->action && in_array( $this->task, array( 'default', 'save' ) ) ) {
				$data .= '<li class="active"><a href="#">' . t( 'dunamis.admin.navbar.' . $item ) . '</a></li>';
			}
			else {
				$uri->setVar( 'action', $item );
				$data .= '<li><a href="' . $uri->toString() . '">' . t( 'dunamis.admin.navbar.' . $item ) . '</a></li>';
			}
		}
	
		$data	.= '</ul>';
		return $data;
	}
	
	
	/**
	 * Builds the title of the page
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.3.3
	 */
	public function buildTitle()
	{
		$base	=	get_baseurl( 'dunamis' );
		$doc	=	dunloader( 'document', true );
	
		$doc->addStyleDeclaration( 'h1#dunamistitle { padding-left: 60px; background: url(' . $base . '/assets/integrator-48.png) no-repeat scroll 6px 50% transparent; height: 52px; line-height: 52px; }' );	// Wipes out WHMCS' h1
	
		$data	= '<h1 id="dunamistitle">' . t( 'dunamis.admin.title', t( 'dunamis.admin.subtitle.' . $this->action . '.' . $this->task ) ) . '</h1>';
		return $data;
	}
	
	
	/**
	 * Retrieves the configuration array for the product in the addon modules menu
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	public function getAdminConfig()
	{
		$data = array(
				"name"			=> t( 'dunamis.addon.title' ),
				"version"		=> "@fileVers@",
				"author"		=> t( 'dunamis.addon.author' ),
				"description"	=> t( 'dunamis.addon.description' ),
				"language"		=> "english",
				"logo"			=> get_baseurl( 'dunamis' ) . 'assets/dunamis-48.png',
				"fields"		=> array()
		);
		
		return $data;
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise()
	{
		static $instance = false;
		
		if (! $instance ) {
			dunloader( 'language', true )->loadLanguage( 'dunamis' );
			dunloader( 'hooks', true )->attachHooks( 'dunamis' );
			dunloader( 'helper', true );
		}
		
		$this->area = 'admin';
		
		global $task;
		
		if ( $task ) {
			$this->task = $task;
		}
	}
	
	
	/**
	 * Method to render the response back to the user
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $data: contains compiled data from the sub-view
	 *
	 * @return		html formatted string
	 * @since		1.3.3
	 */
	public function render( $data = null )
	{
		load_bootstrap( 'dunamis' );
	
		// Compatibility check
		if (! check_compatible( 'dunamis' ) ) $this->setAlert( 'alert.dunamis.compatible', 'error' );
	
		$title	= $this->buildTitle();
		$navbar	= $this->buildNavigation();
		$alerts	= $this->buildAlerts();
		$modals	= $this->buildModals();
	
		$baseurl = get_baseurl( 'dunamis' );
		$doc = dunloader( 'document', true );
	
		$doc->addStyleDeclaration( '#contentarea > div > h1, #content > h1 { display: none; }' );	// Wipes out WHMCS' h1
		$doc->addStyleDeclaration( '.contentarea > h1 { display: none; }' );	// Wipes out WHMCS' h1 in 5.0.3
		$doc->addStyleDeclaration( '#contentarea #dunamis input { height: auto; }' );						// Cleanup Input Height issue in WHMCS v6
		$doc->addStylesheet( $baseurl . 'assets/admin.css' );
	
		return 		'<div style="float:left;width:100%;">'
					.	'<div id="dunamis">'
					.	'	' . $title
					.	'	' . $navbar
					.	'	' . $alerts
					.	'	' . $data
					.	'	' . $modals
					.	'</div>'
					.'</div>';
	}
	
	
	/**
	 * Renders the output for the admin area of the site (WHMCS > Addons > Module name)
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function renderAdminOutput()
	{
		$action	= dunloader( 'input', true )->getVar( 'action', 'default' );
		
		$controller = dunmodule( 'dunamis.' . $action );
		$controller->execute();
	
		return $controller->render();
	}
	
	
	/**
	 * Renders the sidebar for the admin area
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function renderAdminSidebar()
	{
		return;
	}
	
	
	/**
	 * Common method for rendering fields into a form
	 * @access		protected
	 * @version		@fileVers@
	 * @param		array		- $fields: contains an array of Field objects
	 *
	 * @return		string
	 * @since		1.3.3
	 */
	protected function renderForm( $fields = array(), $options = array() )
	{
		$data	= null;
		$foptn	= ( array_key_exists( 'fields', $options ) ? $options['fields'] : array() );
			
		foreach ( $fields as $field ) {
	
			if ( in_array( $field->get( 'type' ), array( 'wrapo', 'wrapc' ) ) ) {
				$data .= $field->field();
				continue;
			}
	
			$data	.= <<< HTML
<div class="control-group">
	{$field->label( array( 'class' => 'control-label' ) )}
	<div class="controls">
		{$field->field( $foptn )}
		{$field->description( array( 'type' => 'span', 'class' => 'help-block help-inline' ) )}
	</div>
</div>
HTML;
		}
	
		return $data;
	}
	
	
	/**
	 * Method for setting the action to the object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $action: the action to set
	 *
	 * @since		1.3.3
	 */
	public function setAction( $action = 'default' )
	{
		$this->action = $action;
	}
	
	
	/**
	 * Method for setting an alert to the object
	 * @access		protected
	 * @version		@fileVers@
	 * @param		mixed		- $msg: contains an array of items to use for translate or an alert msg string
	 * @param		string		- $type: indicates which type of alert to set to
	 * @param		boolean		- $trans: indicates if we should translate (true default)
	 *
	 * @since		1.3.3
	 */
	protected function setAlert( $msg = array(), $type = 'success', $trans = true )
	{
		// If we are passing an array we are assuming:
		//		first item is string
		//		rest of items are variables to insert
		if ( is_array( $msg ) ) {
			$message = array_shift( $msg );
			$message = 'integrator.'.$message;
			array_unshift( $msg, $message );
			$this->alerts[$type][] = call_user_func_array('t', $msg );
			return;
		}
	
		if ( $trans ) {
			$msg = t( 'dunamis.' . $msg );
		}
	
		$this->alerts[$type][] = $msg;
	}
	
	
	/**
	 * Method for setting a modal into place
	 * @access		protected
	 * @version		@fileVers@
	 * @param		string		- $id: the id string of the modal
	 * @param		string		- $title: the title to use
	 * @param		string		- $header: the header of the modal
	 * @param		string		- $body: content of the body
	 * @param		string		- $href: the destination URL of the modal on success
	 * @param		string		- $btnlbl: the label to use for the affirming action button
	 * @param		string		- $type: the style of button to use (success|danger|etc)
	 *
	 * @since		1.3.3
	 */
	protected function setModal( $id, $title, $header, $body, $href, $btnlbl, $type = 'danger' )
	{
		$btns	= array(	'<button data-dismiss="modal" class="btn">' . t( 'dunamis.form.close' ). '</button>',
				'<a href="' . $href . '" class="btn btn-' . $type . '">' . $btnlbl . '</a>'
		);
		$this->modals[]	= array(	'id'		=> $id,
				'title'		=> $title,
				'hdr'		=> $header,
				'body'		=> $body,
				'buttons'	=> $btns
		);
	}
	
	
// 	/**
// 	 * Gathers the body for an admin page
// 	 * @access		private
// 	 * @version		@fileVers@
// 	 * 
// 	 * @return		string
// 	 * @since		1.0.0
// 	 */
// 	private function _getBody()
// 	{
// 		global $action, $whmcs;
		
// 		$data	=   null;
		
// 		switch ( $action ) {
			
// 			case 'updates' :
				
// 				$doc	=	dunloader( 'document', true );
// 				$doc->addStyleSheet( get_baseurl( 'dunamis' ) . 'assets/admin.css' );
// 				$doc->addScript( get_baseurl( 'dunamis' ) . 'assets/updates.js' );
// 				$doc->addScriptDeclaration( "jQuery.ready( checkForUpdates() );" );
				
// 				$data	=	array();
// 				$data[]	=	'<div class="span8" style="text-align: center; ">';
// 				$data[]	=	'<a class="btn" id="btn-updates">';
// 				$data[]	=	'<div class="ajaxupdate ajaxupdate-init">';
// 				$data[]	=	'<span id="upd-title"></span>';
// 				$data[]	=	'<img id="img-updates" class="" />';
// 				$data[]	=	'<span id="upd-subtitle"></span>';
// 				$data[]	=	'</div>';
// 				$data[]	=	'</a>';
// 				$data[]	=	'</div>';
// 				$data[]	=	'<input type="hidden" id="btntitle" value="' . t( 'dunamis.updates.checking.title' ) . '" />';
// 				$data[]	=	'<input type="hidden" id="btnsubtitle" value="' . t( 'dunamis.updates.checking.subtitle' ) . '" />';
// 				$data[]	=	'<input type="hidden" id="dunamisurl" value="' . get_baseurl( 'dunamis' ) . '" />';
				
// 				return implode( "\r\n", $data );
				
// 				break;
// 			case 'home' :
// 			case 'installer' :
				
// 				$data	.=	'<div class="row-fluid">'
// 						.	'	<div class="span12 well">'
// 						.	t( 'dunamis.' . $action . '.subtitle' )
// 						.	t( 'dunamis.' . $action . '.body' )
// 						.	'	</div>'
// 						.	'</div>';
				
// 				break;
				
// 		}
		
// 		return $data;
// 	}
	
	
// 	/**
// 	 * Method to generate the navigation bar at the top
// 	 * @access		private
// 	 * @version		@fileVers@
// 	 * 
// 	 * @return		string
// 	 * @since		1.0.0
// 	 */
// 	private function _getNavigation()
// 	{
// 		$input	= dunloader( 'input', true );
// 		$action	= $input->getVar( 'action', 'home' );
// 		$task	= $input->getVar( 'task', null );
		
// 		$uri	= DunUri :: getInstance('SERVER', true );
// 		$uri->delVar( 'task' );
// 		$uri->delVar( 'submit' );
		
// 		$html	= '<ul class="nav nav-pills">';
		
// 		foreach( array( 'home', 'settings', 'updates', 'installer' ) as $item ) {
			
// 			if ( $item == $action ) {
// 				$html .= '<li class="active"><a href="#">' . t( 'dunamis.admin.navbar.' . $item ) . '</a></li>';
// 				continue;
// 			}
			
// 			$uri->setVar( 'action', $item );
// 			$html .= '<li><a href="' . $uri->toString() . '">' . t( 'dunamis.admin.navbar.' . $item ) . '</a></li>';
// 		}
		
		
// 		$html	.= '</ul>';
// 		return $html;
// 	}
	
	
// 	/**
// 	 * Method to generate the title at the top of the page
// 	 * @access		private
// 	 * @version		@fileVers@
// 	 * 
// 	 * @return		string
// 	 * @since		1.0.0
// 	 */
// 	private function _getTitle()
// 	{
// 		$action	= dunloader( 'input', true )->getVar( 'action', 'home' );
// 		return '<h1>' . t( 'dunamis.admin.title', t( 'dunamis.admin.title.' . $action ) ) . '</h1>';
// 	}
	
	
// 	/**
// 	 * Common method for rendering fields into a form
// 	 * @access		private
// 	 * @version		@fileVers@
// 	 * @param		array		- $fields: contains an array of Field objects
// 	 * 
// 	 * @return		string
// 	 * @since		1.0.0
// 	 */
// 	private function _renderForm( $fields = array(), $options = array() )
// 	{
// 		$data	= null;
// 		$foptn	= ( array_key_exists( 'fields', $options ) ? $options['fields'] : array() );
		 
// 		foreach ( $fields as $field ) {	// Fields of Themes cycle
		
// 			if ( in_array( $field->get( 'type' ), array( 'wrapo', 'wrapc' ) ) ) {
// 				$data .= $field->field();
// 				continue;
// 			}
		
// 			$data	.= <<< HTML
// <div class="control-group">
// 	{$field->label( array( 'class' => 'control-label' ) )}
// 	<div class="controls">
// 		{$field->field( $foptn )}
// 		{$field->description( array( 'type' => 'span', 'class' => 'help-block help-inline' ) )}
// 	</div>
// </div>
// HTML;
// 		}
		
// 		return $data;
// 	}
	
	
// 	/**
// 	 * Method to save the form when saved
// 	 * @access		private
// 	 * @version		@fileVers@
// 	 * 
// 	 * @since		1.0.0
// 	 */
// 	private function _saveForm()
// 	{
		
// 	}
}