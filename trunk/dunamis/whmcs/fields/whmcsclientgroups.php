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

// Ensure the dropdown fields are loaded
dunimport( 'fields.dropdown' );

/**
 * WHMCSClientgroups Field
 * @desc		This is used to render a dropdown of Client Groups for selection in a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsWhmcsclientgroupsDunFields extends DropdownDunFields
{
	/**
	 * Stores the array for excluding user groups
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $_excludes	=	array();
	
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
	 * Stores the value used to separate values sending a string stored in the database 
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $split		=	'|';
	
	/**
	 * Stores the options to select from
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $options		=	array();
	
	/**
	 * Stores the values
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $value		=	array();
	
	
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
		foreach( array( 'split', 'value' ) as $item ) {
			if ( array_key_exists( $item, $settings ) ) {
				
				if ( $item == 'split' ) {
					$this->split = $settings['split'];
					unset( $settings['split'] );
					continue;
				}
				
				if ( strpos( $settings[$item], $this->split ) !== false ) {
					$settings[$item] = explode( $this->split, $settings[$item] );
				}
				
				$this->$item = (array) $settings[$item];
				unset( $settings[$item] );
			}
		}
		
		parent :: __construct( $settings );
		
		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
		}
		
		$this->_loadOptions();
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
		
		if ( isset( $this->attributes['allownogroup'] ) ) {
			unset( $this->attributes['allownogroup'] );
		}
		
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		$name		= ( strpos( $attr, 'multiple' ) !== false ? $name . '[]' : $name );
		$optns		= $this->options;
		
		$form		= '<select id="' . $id . '" name="'.$name.'" '.$attr.">\n";
		$oid		= $this->_optid;
		$oname		= $this->_optname;
		
		foreach ( $optns as $optn ) {
			$optn		=	(object) $optn;
			$selected	=	( in_array( $optn->$oid, $value ) ? ' selected="selected"' : '' ); 
			$form		.=	'<option value="' . $optn->$oid . '"' . $selected . '>' . t( $optn->$oname ) . "</option>\n";
		}
		
		return $form . '</select>';
	}
	
	
	/**
	 * Method to set the exclusion array to filter out items we don't want to render
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $settings: settings to pass along
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function setExcludes( $excludes = array() )
	{
		$this->_excludes = $excludes;
		$this->_loadOptions();
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
	
	
	/**
	 * Method to set the value to the object
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $settings: settings to pass along
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function setValue( $value = array() )
	{
		if ( strpos( $value, $this->split ) !== false ) {
			$value = explode( $this->split, $value );
		}
		
		$this->value = $value;
	}
	
	
	/**
	 * Method to load the admins from the database into the options field
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	private function _loadOptions()
	{
		$db		=	dunloader( 'database', true );
		$data	=	array();
		
		$db->setQuery( "SELECT id, groupname FROM tblclientgroups ORDER BY groupname" );
		$result	= $db->loadObjectList();
		
		if ( isset( $this->attributes['allownogroup'] ) && $this->attributes['allownogroup'] ) {
			if (! in_array( '0', $this->_excludes ) ) {
				$data[]	= (object) array( 'id' => '0', 'name' => "No Group" );
			}
		}
		
		foreach ( $result as $item ) {
			if ( in_array( $item->id, $this->_excludes ) ) continue;
			$data[]	= (object) array( 'id' => $item->id, 'name' => $item->groupname );
		}
		
		$this->setOption( $data );
	}
}