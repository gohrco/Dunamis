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
		// Set a default ID just in case we didn't
		$this->id	= $settings['name'];
		$this->setId( $settings['name'] );
		
		// Get the common names to filter out
		$names		= $this->getPropertyNames();
		
		foreach ( $names as $key ) {
			if (! array_key_exists( $key, $settings ) ) continue;
			$this->$key = $settings[$key];
			$mykey	=	'_' . $key;
			$this->$mykey	=	$settings[$key];
			unset( $settings[$key] );
		}
		
		// The rest of these are attributes
		foreach ( $settings as $key => $value ) {
			$this->attributes[$key] = $value;
			unset( $settings[$key] );
		}
		
		return $settings;
	}
	
	
	/**
	 * Getter / Setter / Haser function
	 * @desc		Use by calling getUrl() or setUrl('value') to get/set $this->_url
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $name: the method invoked
	 * @param		mixed		- $arguments: any arguments passed along
	 *
	 * @return		mixed
	 * @since		1.0.10
	 */
	public function __call( $name, $arguments )
	{
		if ( strpos( $name, 'get' ) !== false && strpos( $name, 'get' ) == 0 ) {
			$var		=	'_' . strtolower( preg_replace( "#^get#", '', $name ) );
			$default	=	(! empty( $arguments ) ? array_shift( $arguments ) : false );
			
			if (! isset( $this->$var ) ) {
				return $default;
			}
			else {
				return $this->$var;
			}
		}
	
		if ( strpos( $name, 'set' ) !== false && strpos( $name, 'set' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^set#", '', $name ) );
			$value		=	array_shift( $arguments );
			$this->$var	=	$value;
			return $this;
		}
	
		if ( strpos( $name, 'has' ) !== false && strpos( $name, 'has' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^has#", '', $name ) );
			$value	=	(bool) ( isset( $this->$var ) && ! empty( $this->$var ) );
			return $value;
		}
	}
	
	
	/**
	 * Returns a description
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	public function getDescription( $options = array() )
	{
		if ( $this->getNodesc( false ) === true || isset( $options['nodesc'] ) ) return null;
		
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
	
	
	/**
	 * Returns a description
	 * @access		public
	 * @deprecated
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
	 * Method to get and clean a value for placing into a form field
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.4
	 */
	public function getValue()
	{
		$value	= $this->value;
		$value	= htmlspecialchars( $value );
		$value	= str_replace( array( "'", '"' ), array( "&#39;", "&quot;" ), $value );
		return $value;
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
	
	
	/**
	 * Gets the common field property names that should not be set as attributes
	 * @access		protected
	 * @version		@fileVers@
	 * 
	 * @return		array
	 * @since		1.0.4
	 */
	protected function getPropertyNames()
	{
		return array(
				'name',
				'id',
				'order',
				'type',
				'label',
				'description',
				'value',
				'validation',
				'group',
				'nodesc',
				'cgdata-intro',		// onscreen help for control group
				'cgdata-position'	// onscreen help for control group
				);
	}
}
