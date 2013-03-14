<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * WHMCS ToggleYN field
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.9
 */
class WhmcsToggleynDunFields extends DunFields
{

	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $settings: settings to pass along
	 *
	 * @since		1.0.9
	 */
	public function __construct( $settings = array() )
	{
		parent :: __construct( $settings );

		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
		}
	}


	/**
	 * Method to render the field
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string containing html
	 * @since		1.0.9
	 */
	public function field()
	{
		$name	=   $this->name;
		$value	=   $this->value;
		$args	=	array_to_string( $this->attributes );
		
		$class	=	str_replace('[', '', str_replace(']', '', $name ) );
		
		$field	=	'<input type="hidden" name="' . $name . '" value="0" />'
				.	'<div class="switch" data-on="primary" data-off="danger" data-on-label="' . t( 'themer.admin.toggleyn.enabled' ) . '" data-off-label="' . t( 'themer.admin.toggleyn.disabled' ). '">'
				.	'	<input value="1" name="' . $name . '" type="checkbox" ' . ( $value == 1 ? ' checked="checked"' : '' ) . ' />'
				.	'</div>';
		
		return $field;
	}
}