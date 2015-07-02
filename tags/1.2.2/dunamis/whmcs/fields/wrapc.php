<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * WHMCS Close Wrap field
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.10
 */
class WhmcsWrapcDunFields extends DunFields
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
		return '</div>';
	}
}