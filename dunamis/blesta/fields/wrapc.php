<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Blesta Close Wrap field
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.3.0
 */
class BlestaWrapcDunFields extends DunFields
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
		return '</div>';
	}
}