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
class DunamisAdminDunModule extends WordpressDunModule
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
	protected $type	= 'addon';
	
	
	/**
	 * Function to render the options page back to user
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.5.0
	 */
	public function admin_options()
	{
		// Permission check
		if (! current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		// In case we are saving...
		$this->execute();
		
		// Grab our option from our database
		$debug = get_option( 'dunamis_debug' );
		
		// Pull in our view
		include __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin_options.php';
		
	}
	
	
	/**
	 * Builds the alerts for display
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing html formatted output
	 * @since		1.5.0
	 */
	public function buildAlerts()
	{
		$data	= null;
		$check	= array( 'success', 'error', 'block', 'info' );
	
		foreach ( $check as $type ) {
			if ( empty( $this->alerts[$type] ) ) continue;
			$data	.=	'<div class="alert alert-' . $type . '"><h4>' . t( 'integrator.alert.' . $type ) . '</h4>'
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
	 * @since		1.5.0
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
	 * @since		1.5.0
	 */
	public function buildNavigation()
	{
		$uri	=	DunUri :: getInstance( 'SERVER', true );
		$uri->delVars();
		$uri->setVar( 'module', 'integrator' );
	
		$data		=	'<ul class="nav nav-pills">';
		$actions	=	array( 'default', 'syscheck', 'settings', 'updates' );
		
		// See if we can test the API
		$config		=	dunloader( 'config', 'integrator' );
		$apiurl		=	$config->get( 'integratorurl', null );
		$token		=	$config->get( 'apitoken', null );
		$activeapi	=	( $apiurl && $token ? true : false ); 
		
		foreach( $actions as $item ) {
			$state	=	( $item != 'apicnxn' ? '' : ( $activeapi ? '' : ' disabled' ) );
			
			if ( $item == $this->action && in_array( $this->task, array( 'default', 'save' ) ) ) {
				$data .= '<li class="active' . $state . '"><a href="#">' . t( 'integrator.admin.navbar.' . $item ) . '</a></li>';
			}
			else {
				$uri->setVar( 'action', $item );
				$data .= '<li class="' . $state . '"><a href="' . $uri->toString() . '">' . t( 'integrator.admin.navbar.' . $item ) . '</a></li>';
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
	 * @since		1.5.0
	 */
	public function buildTitle()
	{
		$base	=	get_baseurl( 'integrator' );
		$doc	=	dunloader( 'document', true );
	
		$doc->addStyleDeclaration( 'h1#integratortitle { padding-left: 60px; background: url(' . $base . '/assets/integrator-48.png) no-repeat scroll 6px 50% transparent; height: 52px; line-height: 52px; }' );	// Wipes out WHMCS' h1
	
		$data	= '<h1 id="integratortitle">' . t( 'integrator.admin.title', t( 'integrator.admin.subtitle.' . $this->action . '.' . $this->task ) ) . '</h1>';
		return $data;
	}
	
	
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
			
			$debug	= ( isset( $_POST['debug'] ) ? $_POST['debug'] : false );
			update_option( 'dunamis_debug', $debug );
			break;
		endswitch;
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
			//dunloader( 'language', true )->loadLanguage( 'integrator' );
			//dunloader( 'hooks', true )->attachHooks( 'integrator' );
			//dunloader( 'helpers', 'integrator' );
			
			// Perform checkstring
			//if ( $this->checkstring != "@checkString@" ) {
			//	return false;
			//}
			
			$instance	= true;
		}
		
		$input	=	dunloader( 'input', true );
		$task	=	$input->getVar( 'task', 'default' );
		
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
	 * @since		1.5.0
	 */
	public function render( $data = null )
	{
		load_bootstrap( 'integrator' );
		
		// Compatibility check
		if (! check_compatible( 'dunamis' ) ) $this->setAlert( 'alert.dunamis.compatible', 'error' );
		
		$title	= $this->buildTitle();
		$navbar	= $this->buildNavigation();
		$alerts	= $this->buildAlerts();
		$modals	= $this->buildModals();
		
		$baseurl = get_baseurl( 'integrator' );
		$doc = dunloader( 'document', true );
		
		$doc->addStyleDeclaration( '#contentarea > div > h1, #content > h1 { display: none; }' );	// Wipes out WHMCS' h1
		$doc->addStyleDeclaration( '.contentarea > h1 { display: none; }' );	// Wipes out WHMCS' h1 in 5.0.3
		$doc->addStyleDeclaration( '#contentarea #integrator input { height: auto; }' );						// Cleanup Input Height issue in WHMCS v6
		$doc->addStylesheet( $baseurl . 'assets/css/admin.css' );
		
		return 		'<div style="float:left;width:100%;">'
					.	'<div id="integrator">'
					.	'	' . $title
					.	'	' . $navbar
					.	'	' . $alerts
					.	'	' . $data
					.	'	' . $modals
					.	'</div>'
					.	'</div>';
	}
	
	
	/**
	 * Renders the output for the admin area of the site (WHMCS > Addons > Module name)
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string containing formatted output
	 * @since		1.5.0
	 */
	public function renderAdminOutput()
	{
		$action	= dunloader( 'input', true )->getVar( 'action', 'default' );
	
		$controller = dunmodule( 'integrator.' . $action );
		$controller->execute();
	
		return $controller->render();
	}
	
	
	/**
	 * Renders the sidebar for the admin area
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.5.0
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
	 * @since		1.5.0
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
	 * @since		1.5.0
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
	 * @since		1.5.0
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
			$msg = t( 'integrator.' . $msg );
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
	 * @since		1.5.0
	 */
	protected function setModal( $id, $title, $header, $body, $href, $btnlbl, $type = 'danger' )
	{
		$btns	= array(	'<button data-dismiss="modal" class="btn">' . t( 'integrator.form.close' ). '</button>',
				'<a href="' . $href . '" class="btn btn-' . $type . '">' . $btnlbl . '</a>'
		);
		$this->modals[]	= array(	'id'		=> $id,
				'title'		=> $title,
				'hdr'		=> $header,
				'body'		=> $body,
				'buttons'	=> $btns
		);
	}
	
}
