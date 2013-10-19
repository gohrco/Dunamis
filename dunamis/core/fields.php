<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Dunamis Core Fields File
 * This is the core Field handler of the Dunamis Framework
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */


/**
 * DunFields Object
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.4
 */
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
		if ( isset( $settings['name'] ) ) {
			$this->setId( $settings['name'] );
		}
		
		// Get the common names to filter out
		$names		= $this->getPropertyNames();
		
		foreach ( $names as $key ) {
			if (! array_key_exists( $key, $settings ) ) continue;
			$this->$key = $settings[$key];
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
		/* GET METHOD HANDLER */
		if ( strpos( $name, 'get' ) !== false && strpos( $name, 'get' ) == 0 ) {
			
			// Lets try object properties first
			$var		=	strtolower( preg_replace( "#^get#", '', $name ) );
			$default	=	(! empty( $arguments ) ? $arguments[0] : false );
			
			if ( isset( $this->$var ) ) {
				return $this->$var;
			}
			
			// Lets see if this is an attribute
			if ( isset( $this->attributes[$var] ) ) {
				return $this->attributes[$var];
			}
			
			// We didn't declare the property, its not an attribute so see if it's a private property
			return parent :: __call( $name, $arguments );
		}
		
		/* SET METHOD HANDLER */
		/* Usage:
		 * 	$field->setItem( value ) - if 'item' is a property of object it gets set as $this->item = value;
		 *  $field->setItem( value ) - if 'item' is not a property of object, it gets set as $this->_item = value;
		 *  $field->setItem( value, true ) - sets the attribute as $this->attributes[item] = value
		 */
		if ( strpos( $name, 'set' ) !== false && strpos( $name, 'set' ) == 0 ) {
			// Lets try object properties first
			$var		=	strtolower( preg_replace( "#^set#", '', $name ) );
			$value		=	(! empty( $arguments ) ? $arguments[0] : false );
			
			if ( property_exists( get_class( $this ), $var ) ) {
				$this->$var = $value;
				return $this;
			}
			
			// Handle attribute settings - requires second argument of true
			if ( count( $arguments ) == 2 && $arguments[1] === true ) {
				$this->attributes[$var] = $value;
				return $this;
			}
			
			// We didn't declare the property, its not an attribute so see if it's a private property
			return parent :: __call( $name, $arguments );
		}
		
		/* HAS METHOD HANDLER */
		if ( strpos( $name, 'has' ) !== false && strpos( $name, 'has' ) == 0 ) {
			// Lets try object properties first
			$var		=	strtolower( preg_replace( "#^has#", '', $name ) );
			
			if ( isset( $this->$var ) && ! empty( $this->$var ) ) {
				return true;
			}
				
			// Lets see if this is an attribute
			if ( isset( $this->attributes[$var] ) && ! empty( $this->attributes[$var] ) ) {
				return true;
			}
			
			// We didn't declare the property, its not an attribute so see if it's a private property
			return parent :: __call( $name, $arguments );
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
	 * Method to get the id from the object
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public function getId()
	{
		$id		=	$this->id;
		$group	=	$this->group;
		
		return ( $group ? $group . '-' . $id : $id );
	}
	
	
	/**
	 * Method to return the label for a field
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: any arguments to set on the label field 
	 *
	 * @return		html formatted string
	 * @since		1.0.0
	 */
	public function getLabel( $options = array() )
	{
		$args	= array_to_string( $options );
		return '<label for="' . $this->getId() . '" ' . $args . '>' . t( $this->label ) . '</label>';
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
	
	
	/* ------------------------------------ *\
	 * DEPRECATED METHODS BELOW AS OF 1.2.0 *
	\* ------------------------------------ */
	
	
	/**
	 * Returns a description
	 * @deprecated
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
		return $this->getDescription( $options );
	}
	
	
	/**
	 * @deprecated
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $item: what we are looking for
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function get( $item )
	{
		$name = 'get' . ucfirst( $item );
		return $this->$name();
	}
	
	
	/**
	 * Returns the label
	 * @deprecated
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function label( $options = array() )
	{
		return $this->getLabel( $options );
// 		$args	= array_to_string( $options );
// 		return '<label for="' . $this->id . '" ' . $args . '>' . t( $this->label ) . '</label>';
	}
	
	
	/**
	 * @deprecated
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $item: the name of the item to set
	 * @param		mixed		- $value: the value to use
	 *
	 * @return		self
	 * @since		1.0.0
	 */
	public function set( $item, $value )
	{
		$name = 'set' . ucfirst( $item );
		return $this->$name( $value );
	}
	
	
	/**
	 * @deprecated
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param unknown_type $name
	 * @param unknown_type $value
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function setAttribute( $name, $value )
	{
		$item	=	'set' . ucfirst( $name );
		return $this->$item( $value, true );
		
// 		$oldvalue	= ( array_key_exists( $name, $this->attributes ) ? $this->attributes[$name] : true );
// 		if ( $value == null ) {
// 			if ( array_key_exists( $name, $this->attributes ) ) unset( $this->attributes[$name] );
// 			return $oldvalue;
// 		}
// 		$this->attributes[$name] = $value;
// 		return $oldvalue;
	}
	
	
	/**
	 * Sets a value into place
	 * @deprecated
	 * @access		public
	 * @version		@fileVers@
	 * @param		mixed		- $value: contains the value to set
	 * 
	 * @return		mixed old settings if set
	 * @since		1.0.0
	 */
	public function deprecated_setValue( $value )
	{
// 		$oldvalue = $this->value;
// 		$this->value = $value;
// 		return $oldvalue;
	}
}
