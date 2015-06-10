<?php
/**
 * @projectName@
 * 
 * @package    @packageName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id: controller.php 349 2015-06-09 03:14:05Z steven_gohigher $ )
 * @author     @buildAuthor@
 * @since      3.0.0
 * 
 * @desc       This is the main controller file for the backend of the Integrator
 *  
 */

/*-- Security Protocols --*/
defined( '_JEXEC' ) or die( 'Restricted access' );
/*-- Security Protocols --*/

/*-- File Inclusions --*/
jimport('joomla.application.component.controller');
/*-- File Inclusions --*/


/**
 * Integrator Controller class object
 * @version		@fileVers@
 * 
 * @since		3.0.0
 * @author		Steven
 */
class DunamisController extends DunamisControllerExt
{
	
	/**
	 * Displays the backend to the user
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		3.0.0
	 */
	public function display( $cachable = false, $urlparams = array() )
	{
		// Call up the parent display task
		parent::display( $cachable, $urlparams );
	}
}