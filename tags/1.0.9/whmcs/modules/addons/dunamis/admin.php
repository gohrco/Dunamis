<?php defined('DUNAMIS') OR exit('No direct script access allowed');

if (! defined( 'DUN_MOD_DUNAMIS' ) ) define( 'DUN_MOD_DUNAMIS', "@fileVers@" );

class DunamisAdminDunModule extends WhmcsDunModule
{
	/**
	 * Stores the type of module this is
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $type	= 'addon';
	
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
				"name"			=> t( 'dunamis.config.title' ),
				"version"		=> "@fileVers@",
				"author"		=> t( 'dunamis.config.author' ),
				"description"	=> t( 'dunamis.config.description' ),
				"logo"			=> get_baseurl() . 'includes/dunamis/whmcs/assets/dunamis-48.png',
				"language"		=> "english",
				"fields"		=> array(
						"DebugErrors"	=> array (
						"FriendlyName"	=> t( 'dunamis.config.debugerrors' ),
						"Type"			=> "dropdown",
						"Options"		=> t( 'dunamis.config.debugerrors.selection' ),
						"Description"	=> t( 'dunamis.config.debugerrors.desc' )
					),
						"ErrorLevel"	=> array (
						"FriendlyName"	=> t( 'dunamis.config.errorlevel' ),
						"Type"			=> "dropdown",
						"Options"		=> t( 'dunamis.config.errorlevel.selection' ),
						"Description"	=> t( 'dunamis.config.errorlevel.desc' )
					),
				)
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
		$this->area = 'admin';
		
		dunloader( 'language', true )->loadLanguage( 'dunamis' );
		dunloader( 'hooks', true )->attachHooks( 'dunamis' );
	
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
		global $action, $whmcs;
		if (! $action ) $action = 'home';
		
		$input	=	dunloader( 'input', true );
		$submit	=	$input->getVar( 'submit', false );
		
		if ( $submit ) {
			$this->_saveForm();
		}
		
		$doc		=   dunloader( 'document', true );
		$baseurl 	=   get_baseurl( 'dunamis' );
		
		$doc->addStyleDeclaration( '#contentarea > div > h1, #content > h1 { display: none; }' );	// Wipes out WHMCS' h1
		$doc->addStyleDeclaration( '.contentarea > h1 { display: none; }' );	// Wipes out WHMCS' h1 in 5.0.3
		
		load_bootstrap( 'dunamis' );
		
		$title	= $this->_getTitle();
		$navbar = $this->_getNavigation();
		$body	= $this->_getBody();
		
		$data	= <<< HTML
<div style="float:left;width:100%;">
	<div id="dunamis">
		{$title}
		{$navbar}
		{$body}
	</div>
</div>
<div style="clear: both; "> </div>
HTML;
		return $data;
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
	 * Gathers the body for an admin page
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _getBody()
	{
		global $action, $whmcs;
		
		$data	=   null;
		
		switch ( $action ) {
			
			case 'home' :
			case 'updates' :
			case 'installer' :
				
				$data	.=	'<div class="row-fluid">'
						.	'	<div class="span12 well">'
						.	t( 'dunamis.' . $action . '.subtitle' )
						.	t( 'dunamis.' . $action . '.body' )
						.	'	</div>'
						.	'</div>';
				
				break;
				
		}
		
		return $data;
	}
	
	
	/**
	 * Method to generate the navigation bar at the top
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _getNavigation()
	{
		$input	= dunloader( 'input', true );
		$action	= $input->getVar( 'action', 'home' );
		$task	= $input->getVar( 'task', null );
		
		$uri	= DunUri :: getInstance('SERVER', true );
		$uri->delVar( 'task' );
		$uri->delVar( 'submit' );
		
		$html	= '<ul class="nav nav-pills">';
		
		foreach( array( 'home', 'updates', 'installer' ) as $item ) {
			
			if ( $item == $action ) {
				$html .= '<li class="active"><a href="#">' . t( 'dunamis.admin.navbar.' . $item ) . '</a></li>';
				continue;
			}
			
			$uri->setVar( 'action', $item );
			$html .= '<li><a href="' . $uri->toString() . '">' . t( 'dunamis.admin.navbar.' . $item ) . '</a></li>';
		}
		
		
		$html	.= '</ul>';
		return $html;
	}
	
	
	/**
	 * Method to generate the title at the top of the page
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _getTitle()
	{
		$action	= dunloader( 'input', true )->getVar( 'action', 'home' );
		return '<h1>' . t( 'dunamis.admin.title', t( 'dunamis.admin.title.' . $action ) ) . '</h1>';
	}
	
	
	/**
	 * Common method for rendering fields into a form
	 * @access		private
	 * @version		@fileVers@
	 * @param		array		- $fields: contains an array of Field objects
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _renderForm( $fields = array(), $options = array() )
	{
		$data	= null;
		$foptn	= ( array_key_exists( 'fields', $options ) ? $options['fields'] : array() );
		 
		foreach ( $fields as $field ) {	// Fields of Themes cycle
		
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
	 * Method to save the form when saved
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	private function _saveForm()
	{
		
	}
}