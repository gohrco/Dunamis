<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @projectName@ - Updates Module Base File
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.4.0
 *
 * @desc       This file handles the updates for the product
 *
 */


/**
 * Updates Module Class for Dunamis
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.4.0
 */
class DunamisUpdatesDunModule extends DunamisAdminDunModule
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
		$this->action = 'updates';
		parent :: initialise();
	}
	
	/**
	 * Method to execute tasks
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.4.0
	 */
	public function execute() { }
	
	
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
		load_bootstrap( 'dunamis' );
		
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
		$doc	=	dunloader( 'document', true );
		$doc->addStyleSheet( get_baseurl( 'dunamis' ) . 'assets/admin.css' );
		$doc->addScript( get_baseurl( 'dunamis' ) . 'assets/updates.js' );
		$doc->addScriptDeclaration( "jQuery.ready( checkForUpdates() );" );

		$data	=	array();
		$data[]	=	'<div class="span8" style="text-align: center; ">';
		$data[]	=	'<a class="btn" id="btn-updates">';
		$data[]	=	'<div class="ajaxupdate ajaxupdate-init">';
		$data[]	=	'<span id="upd-title"></span>';
		$data[]	=	'<img id="img-updates" class="" />';
		$data[]	=	'<span id="upd-subtitle"></span>';
		$data[]	=	'</div>';
		$data[]	=	'</a>';
		$data[]	=	'</div>';
		$data[]	=	'<input type="hidden" id="btntitle" value="' . t( 'dunamis.updates.checking.title' ) . '" />';
		$data[]	=	'<input type="hidden" id="btnsubtitle" value="' . t( 'dunamis.updates.checking.subtitle' ) . '" />';
		$data[]	=	'<input type="hidden" id="dunamisurl" value="' . get_baseurl( 'dunamis' ) . '" />';

		return implode( "\r\n", $data );
	}
}