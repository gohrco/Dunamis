<?php


class PasswordDunFields extends DunFields
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
		
		return '<input type="password" name="' . $name . '" id="' . $id . '" value="' . $value . '" ' . $attr . ' />';
	}
}