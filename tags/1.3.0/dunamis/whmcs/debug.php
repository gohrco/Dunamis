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
 * Dunamis Debug handler for WHMCS
 * @desc		This is the debug handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunDebug extends DunDebug
{
	
	/**
	 * Method to initialize the debug object
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $name: the calling name
	 *
	 * @since		1.0.11
	 */
	public static function init()
	{
		// Check to see if we are enabled or not
		if (! self :: isEnabled() ) {
			return;
		}
		
		// Lets initialized
		parent :: init();
	}
	
	
	/**
	 * Method to check if debugging is enabled
	 * @access		public
	 * @static
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.11
	 */
	protected static function isEnabled()
	{
		if ( self :: $isEnabled === null ) {
			self :: $isEnabled = get_errorsetting_whmcs( 'DebugErrors' );
		}
		
		return (bool) self :: $isEnabled;
	}
}


class WDD extends WhmcsDunDebug {}