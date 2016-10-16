<?php
/**
 * @projectName@
 * 
 * @package    @packageName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.4.0
 * 
 * @desc       This file renders the default view to the admin user
 *  
 */

/*-- Security Protocols --*/
defined( '_JEXEC' ) or die( 'Restricted access' );
/*-- Security Protocols --*/

/*-- File Inclusions --*/
jimport( 'joomla.application.component.view' );
/*-- File Inclusions --*/

/**
 * IntegratorViewDefault class object
 * @version		@fileVers@
 * 
 * @since		3.0.0
 * @author		Steven
 */
class DunamisViewDefault extends DunamisViewExt
{
	
	/**
	 * Displays the backend to the user
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $tpl: template name (unused)
	 * 
	 * @since		3.0.0
	 */
	public function display($tpl = null)
	{
		$toolbar			=	dunloader( 'toolbar',	'com_dunamis' );
		
		$toolbar->title( 'default' );
		$toolbar->add( 'default' );
		
		$db	=	dunloader( 'database' );
		
		parent::display($tpl);
	}
}