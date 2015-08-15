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
 * Dunamis Language handler for WHMCS
 * @desc		This permits our own translation to be used within WHMCS for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunLanguage extends DunLanguage
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		parent :: __construct( $options );
		
		// Attempt to determine the language automatically
		$idiom	= $this->_findLanguage();
		$this->setIdiom( $idiom );
	}
	
	
	/**
	 * Method for determining which language we are using
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	private function _findLanguage()
	{
		return 'english';
		if ( is_admin() ) {
			if ( array_key_exists( 'aInt', $GLOBALS ) ) {
				$aInt = $GLOBALS['aInt'];
				return $aInt->language;
			}
			else if ( array_key_exists( 'calanguage', $GLOBALS ) ) {
				return $GLOBALS['calanguage'];
			}
			else {
				return 'english';
			}
		}
		else {
			global $smarty;
			
			// In case we haven't initialized the system
			if (! is_object( $smarty ) ) return 'english';
			 
			$language	= $smarty->_tpl_vars['language'];
			return strtolower( $language );
		}
		
	}
	
}