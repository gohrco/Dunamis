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
	 * Stores the On Label
	 * @access		protected
	 * @var			string
	 * @since		1.0.10
	 */
	protected $labelon	=	'field.toggleyn.enabled';
	
	
	/**
	 * Stores the On Label
	 * @access		protected
	 * @var			string
	 * @since		1.0.10
	 */
	protected $labeloff	=	'field.toggleyn.disabled';
	
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
		
		// Pull local settings
		foreach ( array( 'labelon', 'labeloff' ) as $item ) {
			if (! isset( $settings[$item] ) ) continue;
			$this->$item	= $settings[$item];
			unset( $settings[$item] );
		}
		
		// Set the attributes
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
				.	'<div class="switch" data-on="primary" data-off="danger" data-on-label="' . t( $this->labelon ) . '" data-off-label="' . t( $this->labeloff ). '">'
				.	'	<input value="1" name="' . $name . '" type="checkbox" ' . ( $value == 1 ? ' checked="checked"' : '' ) . ' />'
				.	'</div>';
		
		return $field;
	}
}