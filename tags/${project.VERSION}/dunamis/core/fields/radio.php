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
 * Radio Field
 * @desc		This is used to render a series of radio fields for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class RadioDunFields extends DunFields
{
	protected $_optid	= 'id';
	protected $_optname	= 'name';
	protected $options	= array();
	protected $value	= array();
	
	public function __construct( $settings = array() )
	{
		foreach( array( 'options', 'value' ) as $item ) {
			if ( array_key_exists( $item, $settings ) ) {
				$this->$item = (array) $settings[$item];
				unset( $settings[$item] );
			}
		}
		
		parent :: __construct( $settings );
		
		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
		}
	}
	
	
	/**
	 * Renders a form field
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string containing form field
	 * @since		1.0.0
	 */
	public function field( $options = array() )
	{
		$name		= $this->name;
		$value		= (array) $this->value;
		$id			= $this->id;
		
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		$optns		= $this->options;
		
		$form		= null;
		
		$oid		= $this->_optid;
		$oname		= $this->_optname;
		
		foreach ( $optns as $optn ) {
			$optn = (object) $optn;
			$selected	= ( in_array( $optn->$oid, $value ) ? ' checked' : '' );
			$form .= '<input type="radio" name="' . $name . '" id="' . $id . $optn->$oid . '" value="' . $optn->$oid . '"' . $attr . $selected . '>' . t( $optn->$oname ) . "&nbsp;&nbsp;\n";
		}
		
		return $form;
	}
	
	
	/**
	 * Method to set an array option to the field
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains array of name | id pairs
	 * 
	 * @since		1.0.0
	 */
	public function setOption( $options = array() )
	{
		$this->options = $options;
	}
}