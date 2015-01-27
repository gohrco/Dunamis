<?php
/**
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Dunamis Form class for Blesta
 * @desc		This is the form handler for creating and handling forms with the Blesta environment
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class BlestaDunForm extends DunForm
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to set
	 * 
	 * @since		1.0.0
	 */
	public function __construct()
	{
		parent :: __construct();
		
		Loader :: loadHelpers( $this, array( "Form" ) );
	}
}