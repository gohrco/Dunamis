<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * WHMCS Information field
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.10
 */
class WhmcsInformationDunFields extends DunFields
{
	/**
	 * Stores the value to render back
	 * @access		protected
	 * @var			array
	 * @since		1.0.10
	 */
	protected $value	= array();
	
	
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
		foreach( array( 'value' ) as $item ) {
			if ( array_key_exists( $item, $settings ) ) {
				$this->$item = (array) $settings[$item];
				unset( $settings[$item] );
			}
		}
		
		parent :: __construct( $settings );
	}
	
	
	/**
	 * Renders a form field
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string containing form field
	 * @since		1.0.10
	 */
	public function field( $options = array() )
	{
		$values	= (array) $this->value;
		$data	= '<div style="padding-top: 7px; ">' . implode( "\n", $values ) . '</div>';
		return $data;
		foreach ( $values as $row ) {
			$data	.= '<div>' . $row . '</div>';
		}
		
		return $data . '</div>';
	}
}