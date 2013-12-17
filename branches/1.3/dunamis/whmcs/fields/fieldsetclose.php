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
 * Fieldset Close Field
 * @desc		This is used to close a fieldset for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class WhmcsFieldsetcloseDunFields extends DunFields
{
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $settings: settings to pass along
	 *
	 * @return		void
	 * @since		1.0.10
	 */
	public function __construct( $settings = array() )
	{
		parent :: __construct( $settings );
		
		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
		}
	}
	
	
	/**
	 * Renders the field back
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: any options to passa long
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	public function field( $options = array() )
	{
		return '</fieldset>';
	}
}