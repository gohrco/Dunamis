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
 * Dunamis Language class for Blesta
 * @desc		This loads our language capabilities for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class BlestaDunLanguage extends DunLanguage
{
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.3.0
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
	 * @since		1.3.0
	 */
	private function _findLanguage()
	{
		$lang	=	Configure :: get( 'Language.default' );
		$map	=	self :: _getLanguageMap();
		
		if (! isset( $map[$lang] ) ) {
			$lang	=	'en_us';
		}
		
		return $map[$lang];
	}
	
	
	/**
	 * Gets a map of local languages to Dunamis names
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array		Contains an array of local to dunamis names ie en_us => english
	 * @since		1.3.0
	 */
	private static function _getLanguageMap()
	{
		return array(
			'en_us'	=>	'english',
		);
	}
}