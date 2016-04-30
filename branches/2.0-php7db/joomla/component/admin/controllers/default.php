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
 * @desc       Default controller for Integrator 3
 *
 */

// Deny direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );


/**
 * IntegratorControllerDefault class is the default task handler for the admin area
 * @version		@fileVers@
 *
 * @since		1.4.0
 * @author		Steven
 */
class DunamisControllerDefault extends DunamisControllerExt
{

	/**
	 * Constructor task
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.4.0
	 */
	public function __construct()
	{
		parent::__construct();
	}



	/**
	 * Display task
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.4.0
	 * @see			DunamisController :: display()
	 */
	public function display()
	{
		$input	=	dunloader( 'input', true );
		$input->setVar( 'view', 'default' );
		
		
		parent::display();
	}
	
}