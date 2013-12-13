<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Blesta Open Wrap field
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.3.0
 */
class BlestaWrapoDunFields extends DunFields
{
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $settings: settings to pass along
	 *
	 * @since		1.3.0
	 */
	public function __construct( $settings = array() )
	{
		parent :: __construct( $settings );
		
		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
		}
	}
	
	
	/**
	 * Renders the description back
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to passa long
	 *
	 * @return		string
	 * @since		1.3.0
	 */
	public function description( $options = array() )
	{
		return null;
	}
	
	
	/**
	 * Renders the field back
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to passa long
	 *
	 * @return		string
	 * @since		1.3.0
	 */
	public function field( $options = array() )
	{
		$name		= $this->name;
		$value		= $this->value;
		$id			= $this->getId();
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		
		return '<div id="' . $id . '" ' . $attr . '>';
	}
	
	
	/**
	 * Renders the label back
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string
	 * @since		1.3.0
	 * @see			DunFields::label()
	 */
	public function label( $options = array() )
	{
		return null;
	}
}