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
class WhmcsDunLanguage extends DunLanguage
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
		
		// Set the language
		$this->setIdiom();
	}
	
	
	/**
	 * Method for determining which language we are using
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function setIdiom( $idom = null )
	{
		if ( $idiom == null ) {
			if ( is_admin() ) {
				if ( array_key_exists( 'aInt', $GLOBALS ) ) {
					$aInt	=	$GLOBALS['aInt'];
					$idiom	=	$aInt->language;
				}
				else if ( array_key_exists( 'calanguage', $GLOBALS ) ) {
					$idiom	=	$GLOBALS['calanguage'];
				}
				else {
					$idiom	=	'english';
				}
			}
			else {
				global $smarty;
				
				// In case we haven't initialized the system
				if (! is_object( $smarty ) ) return 'english';
				 
				$language	=	$smarty->_tpl_vars['language'];
				$idiom		=	strtolower( $language );
			}
		}
		
		parent :: setIdiom( $idiom );
		
	}
	
}