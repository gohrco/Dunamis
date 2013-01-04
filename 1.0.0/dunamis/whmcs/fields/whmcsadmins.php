<?php

dunimport( 'fields.dropdown' );

class WhmcsWhmcsadminsDunFields extends DropdownDunFields
{
	protected $_optid	= 'id';
	protected $_optname	= 'name';
	protected $split	= '|';
	protected $options	= array();
	protected $value	= array();
	
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
		
		parent :: __construct( &$settings );
		
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
		
		$attr		= array_to_string( array_merge( $this->attributes, $options ) );
		$name		= ( strpos( $attr, 'multiple' ) !== false ? $name . '[]' : $name );
		$optns		= $this->options;
		
		$form		= '<select id="' . $id . '" name="'.$name.'"'.$attr.">\n";
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
		$db		= & dunloader( 'database', true );
		$data	=	array();
		
		$db->setQuery( "SELECT firstname, lastname, username, id FROM tbladmins ORDER BY lastname, firstname" );
		$result	= $db->loadObjectList();
		
		foreach ( $result as $item ) {
			$data[]	= (object) array( 'id' => $item->id, 'name' => "{$item->firstname} {$item->lastname}  ({$item->username})" );
		}
		
		$this->setOption( $data );
	}
}