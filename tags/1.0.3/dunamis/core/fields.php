<?php defined('DUNAMIS') OR exit('No direct script access allowed');


class DunFields extends DunObject
{
	protected $attributes	= array();
	protected $id			= null;
	protected $description	= null;
	protected $group		= null;
	protected $label		= null;
	protected $name			= null;
	protected $nodesc		= false;
	protected $order		= 0;
	protected $type			= null;
	protected $value		= null;
	protected $validation	= null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $settings: the settings array being passed to us
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $settings = array() )
	{
		$this->id	= $settings['name'];
		
		foreach ( array( 'name', 'id', 'order', 'type', 'label', 'description', 'value', 'validation', 'group', 'nodesc' ) as $key ) {
			if (! array_key_exists( $key, $settings ) ) continue;
			$this->$key = $settings[$key];
			unset( $settings[$key] );
		}
	}
	
	
	/**
	 * Returns a description
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function description( $options = array() )
	{
		if ( $this->nodesc == true || isset( $options['nodesc'] ) ) return null;
		
		$usetype = 'div';
		if ( isset( $options['type'] ) ) {
			$usetype = $options['type'];
			unset( $options['type'] );
		}
		
		$args	= array_to_string( $options );
		
		$desc	=	( $usetype != 'none' ? '<' . $usetype . ' ' . $args . '>' : '' )
				.	t( $this->description )
				.	( $usetype != 'none' ? '</' . $usetype . '>' : '' );
		
		return $desc;
	}
	
	
	public function get( $item )
	{
		if ( isset( $this->$item ) ) {
			return $this->$item;
		}
	}
	
	
	public function getId()
	{
		$id = $this->id;
		$group	= $this->group;
		
		return ( $group ? $group . '-' . $id : $id );
	}
	
	
	/**
	 * Returns the label
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function label( $options = array() )
	{
		$args	= array_to_string( $options );
		return '<label for="' . $this->id . '" ' . $args . '>' . t( $this->label ) . '</label>';
	}
	
	
	public function set( $item, $value )
	{
		$this->$item = $value;
	}
	
	public function setAttribute( $name, $value )
	{
		$oldvalue	= ( array_key_exists( $name, $this->attributes ) ? $this->attributes[$name] : true );
		if ( $value == null ) {
			if ( array_key_exists( $name, $this->attributes ) ) unset( $this->attributes[$name] );
			return $oldvalue;
		}
		$this->attributes[$name] = $value;
		return $oldvalue;
	}
	
	
	/**
	 * Sets a value into place
	 * @access		public
	 * @version		@fileVers@
	 * @param		mixed		- $value: contains the value to set
	 * 
	 * @return		mixed old settings if set
	 * @since		1.0.0
	 */
	public function setValue( $value )
	{
		$oldvalue = $this->value;
		$this->value = $value;
		return $oldvalue;
	}
}
