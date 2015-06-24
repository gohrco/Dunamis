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
 * Installer Module Class for Dunamis
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.4.0
 */
class DunamisInstallerDunModule extends DunamisAdminDunModule
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
		$this->action = 'installer';
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
		$data	=	'<div class="row-fluid">'
				.	'	<div class="span12 well">'
				.	t( 'dunamis.installer.subtitle' )
				.	t( 'dunamis.installer.body' )
				.	'	</div>'
				.	'</div>';
		return $data;
	}
}