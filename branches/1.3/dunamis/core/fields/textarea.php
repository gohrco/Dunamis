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
 * Textarea Field
 * @desc		This is used to render a textarea field for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class TextareaDunFields extends DunFields
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
		$value		= $this->getValue();
		$id			= $this->id;
		
		if (! isset( $this->attributes['size'] ) ) $this->attributes['size'] = '40';
		
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		
		return '<textarea id="' . $id . '" name="' . $name .'" ' . $attr . '>' . $value . '</textarea>';
	}
}