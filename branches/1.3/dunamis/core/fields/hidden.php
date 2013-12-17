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
 * Hidden Field
 * @desc		This is used to render a hidden field for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class HiddenDunFields extends DunFields
{
	
	public function __construct( $settings = array() )
	{
		parent :: __construct( $settings );
		
		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
		}
	}
	
	
	public function field( $options = array() )
	{
		$name		= $this->name;
		$value		= $this->value;
		$id			= $this->id;
		
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		
		return '<input type="hidden" name="' . $name . '" id="' . $id . '" value="' . $value . '" ' . $attr . ' />';
	}
}