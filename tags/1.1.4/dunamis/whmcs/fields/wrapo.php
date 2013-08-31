<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * WHMCS Open Wrap field
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.10
 */
class WhmcsWrapoDunFields extends DunFields
{
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $settings: settings to pass along
	 *
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
	 * Renders the description back
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: any options to passa long
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	public function description( $options = array() )
	{
		return null;
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
		$name		= $this->name;
		$value		= $this->value;
		$id			= $this->getId();
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		
		return '<div id="' . $id . '" ' . $attr . '>';
	}
	
	
	/**
	 * Renders the label back
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string
	 * @see			DunFields::label()
	 */
	public function label( $options = array() )
	{
		return null;
	}
}