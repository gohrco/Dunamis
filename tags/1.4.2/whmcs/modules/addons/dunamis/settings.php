<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @projectName@
 * Integrator 3 - Settings Module File
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      3.1.00
 *
 * @desc       This file is the settings controller
 *
 */


/**
 * Settings Module Class for Integrator 3
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		3.1.00
 */
class DunamisSettingsDunModule extends DunamisAdminDunModule
{
	/**
	 * Provide means to check for file integrity
	 * @access		protected
	 * @var			string
	 * @since		3.1.00
	 */
	protected $checkstring	=	"@checkString@";
	
	/**
	 * Initialise the object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		3.1.00
	 * @see			IntegratorAdminDunModule :: initialise()
	 */
	public function initialise()
	{
		$this->action = 'settings';
		parent :: initialise();
	}
	
	/**
	 * Method to execute tasks
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		3.1.00
	 */
	public function execute()
	{
		$db		=	dunloader( 'database', true );
		$input	=	dunloader( 'input', true );
		
		switch ( $this->task ):
		case 'save' :
			
			$config		=	dunloader( 'config', 'dunamis' );
			$values		=	$config->getValues();
			
			foreach ( $values as $item => $default ) {
				
				$key = $item;
				$value = $input->getVar( $item, $default );
				
				if ( is_array( $value ) ) $value = implode( '|', $value );
				
				$config->set( $key, $value );
			}
			
			$config->save();
			$this->setAlert( 'alert.settings.saved' );
			
			break;
		endswitch;
		
	}
	
	
	/**
	 * Method to render back the view
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing formatted output
	 * @since		3.1.00
	 */
	public function render( $data = null )
	{
		$data	= $this->buildBody();
		
		return parent :: render( $data );
	}
	
	
	/**
	 * Builds the body of the action
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing html formatted output
	 * @since		3.1.00
	 */
	public function buildBody()
	{
		$form	=	dunloader( 'form', true );
		$values	=	dunloader( 'config', 'dunamis' )->getValues( true );
		$fields	=	new stdClass();
		
		// Cycle through the fields now...
		foreach ( array( 'general' ) as $i ) {
			$form->setValues( $values, 'dunamis.setting-' . $i );
			$fields->$i	= $form->loadForm( 'setting-' . $i, 'dunamis' );
		}
		
		
		$data	=	'<form action="addonmodules.php?module=dunamis&action=settings&task=save" class="form-horizontal" method="post">'
				.	'	<div class="tabbable tabs-left">'
				.	'		<ul class="nav nav-tabs">'
				.	'			<li class="active"><a href="#general" data-toggle="tab">' . t( 'dunamis.admin.settings.subnav.general' ) . '</a></li>'
				.	'		</ul>'
				.	'		<div class="tab-content">'
				.	'			<div class="tab-pane active" id="general">'
				.	'				' . $this->renderForm( $fields->general )
				.	'			</div>'
				.	'		</div>'
				.	'	</div>'
				.	'	<div class="form-actions">'
				.			$form->getButton( 'submit', array( 'class' => 'btn btn-primary span2', 'value' => t( 'dunamis.form.submit' ), 'name' => 'submit' ) )
				.	'		<a href="addonmodules.php?module=dunamis&action=default" class="btn btn-inverse pull-right span2">' . t( 'dunamis.form.close' ) . '</a>'
				.	'	</div>'
				.	'</form>';
		
		return $data;
	}
}