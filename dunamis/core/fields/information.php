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
 * Information Field
 * @desc		This is used to render HTML for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class InformationDunFields extends DunFields
{
	/**
	 * Stores the value to render back
	 * @access		protected
	 * @var			array
	 * @since		1.3.0
	 */
	protected $value	= array();
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $settings: settings to pass along
	 *
	 * @since		1.3.0
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
	 * @since		1.3.0
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