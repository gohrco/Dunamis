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
 * Toggle Button Field
 * @desc		This is used to render and manage the toggle button field for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class BlestaTogglebtnDunFields extends DunFields
{
	
	/**
	 * Stores the value used to identify the id in the options passed along
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $_optid	= 'id';
	
	/**
	 * Stores the value used to identify the name in the options passed along
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $_optname	= 'name';
	
	/**
	 * Stores the options passed along to the field
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $options	= array();
	
	/**
	 * Stores the value assigned to the field
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $value	= array();
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $settings: settings to pass along
	 *
	 * @return		void
	 * @since		1.0.0
	 */
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
	 * Renders the field back
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: any options to pass along
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public function field()
	{
		$name		=	$this->name;
		$value		=	(array) $this->value;
		$id			=	$this->getId();
		$onclick	=	null;
		$class		=	null;
		
		// Catch onclicks
		if ( isset( $this->attributes['onclick'] ) ) {
			$onclick = $this->attributes['onclick'];
			unset( $this->attributes['onclick'] );
		}
		
		if ( isset ( $this->attributes['class'] ) ) {
			$class = $this->attributes['class'];
			unset( $this->attributes['class'] );
		}
		
		$attr		=	array_to_string( $this->attributes );
		$optns		=	$this->options;
		$oid		=	$this->_optid;
		$oname		=	$this->_optname;
		
		$field		=	'<div class="btn-group" data-toggle="buttons-radio">'
					.	'<input type="hidden" id="' . $id . '" name="' . $name . '" value="' . $value[0] . '" />';
		
		foreach ( $optns as $optn ) {
			$optn		=	(object) $optn;
			$selected	=	( in_array( $optn->$oid, $value ) ? 'active ' : '' );
			$field		.=	'<button type="button" class="btn btn-primary ' . $selected . $class
						. '" onclick="javascript:togglebtns(\'' . $id . '\', ' . $optn->$oid . ' ); ' . $onclick . '">'
						. t( $optn->$oname ) . '</button>';
		}
		
		$this->_addJavascript();
		
		return $field . '</div>';
	}
	
	
	/**
	 * Adds the javascript to the document
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	private function _addJavascript()
	{
		static $data = false;
		
		$doc	= dunloader( 'document', true );
		
		if (! $data ) {
			$base	= get_baseurl( 'client' );
			$uri	= DunUri :: getInstance( $base, true );
			$uri->delVars();
			$doc->addScript( rtrim( $base, '/' ) . '/plugins/dunamis/framework/dunamis/core/assets/js/togglebtns.js' );
			$data	= true;
		}
		
		$id		= $this->getId();
		$value	= $this->get( 'value' );
		$value	= $value === null ? array('1') : $value;
		$doc->addScriptDeclaration( 'jQuery("document").ready( function () { togglebtns(\'' . $id . '\', \'' . $value[0] . '\' ); });' );
	}
}