<?php defined('DUNAMIS') OR exit('No direct script access allowed');


class DunForm extends DunObject
{
	/**
	 * Stores an array of loaded and supported field types
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected	$fields	= array();
	
	/**
	 * Stores an array of forms that have been loaded
	 * @access		protected
	 * @static
	 * @var			array
	 * @since		1.0.0
	 */
	protected static $forms		= array();
	
	/**
	 * Stores an instance of the form object
	 * @access		protected
	 * @static
	 * @var			object
	 * @since		1.0.0
	 */
	protected static $instance	= null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to set
	 * 
	 * @since		1.0.0
	 */
	public function __construct()
	{
		dunimport( 'core.fields', false );
	}
	
	
	/**
	 * Method to add an individual field to a form
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $name: the name of the field to add
	 * @param		object		- $field: the field definition to use
	 * @param		string		- $moduleform: the form to attach to (module.form)
	 *
	 * @return		boolean
	 * @since		1.1.0
	 */
	public function addField( $name, $field, $moduleform )
	{
		$field	=	(object) $field;
		$parts	=	explode( '.', $moduleform );
		$module	=	array_shift( $parts );
		$form	=	implode( '.', $parts );
		
		$class = dunimport( 'fields.' . $field->type, $module );
			
		if (! $class ) return false;
			
		switch ( $class ) {
			case 'core' :
				$classname = ucfirst( $field->type . 'DunFields' );
				break;
			case 'env' :
				$classname = ucfirst( strtolower( DUN_ENV ) ) . ucfirst( $field->type ) .'DunFields';
				break;
			case 'mod' :
				$classname = ucfirst( $module ) . ucfirst( $field->type ) . 'DunFields';
				break;
		}
			
		if (! array_key_exists( 'name', $field ) ) $field->name = $name;
		
		self :: $forms[$moduleform][$name]	=	new $classname( (array) $field );
		
		return true;
	}
	
	
	/**
	 * Method to delete a field from a form
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $field: the field name to remove
	 * @param		string		- $form: the module.form to remove from
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function deleteField( $field, $form )
	{
		if (! isset( self :: $forms[$form] ) ) {
			$parts = explode( '.', $form );
			$this->loadForm( $parts[1], $parts[0] );
		}
		
		$fields = self :: $forms[$form];
		
		if ( array_key_exists( $field, $fields ) ) unset( $fields[$field] );
		else return false;
		
		self :: $forms[$form] = $fields;
		
		return true;
	}
	
	
	/**
	 * Common method for getting a button
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $type: the type of button to build
	 * @param		array		- $args: arguments to add to the button
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function getButton( $type = 'submit', $args )
	{
		$args	= array_to_string( $args );
		return '<input type="' . $type . '" ' . $args . ' />';
	}
	
	
	/**
	 * Get a single field from a form
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $field: the field name to get
	 * @param		string		- $form: the form to get it from
	 * 
	 * @return		instance of DunField or false on error
	 * @since		1.0.0
	 */
	public function getField( $field, $form )
	{
		if (! isset( self :: $forms[$form] ) ) {
			$parts = explode( '.', $form );
			$this->loadForm( $parts[1], $parts[0] );
		}
		
		$fields = self :: $forms[$form];
		
		return ( array_key_exists( $field, $fields ) ? $fields[$field] : false );
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance()
	{
		if (! is_object( self :: $instance ) ) {
			
			if ( defined( 'DUN_ENV' ) ) {
				$classname = ucfirst( strtolower( DUN_ENV ) ) . 'DunForm';
				self :: $instance	= new $classname();
			}
			else {
				self :: $instance = new self();
			}
			
		}
		
		return self :: $instance;
	}
	
	
	/**
	 * Loads a set of form objects
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $file: the filename to pull up
	 * @param		string		- $module: the extension to reference
	 * 
	 * @return		array of objects
	 * @since		1.0.0
	 */
	public function loadForm( $file = null, $module = null )
	{
		if ( isset( self :: $forms[$module . '.' . $file] ) ) return self :: $forms[$module . '.' . $file];
		
		$paths		=   array();
		$paths[]	=	get_dunamis( $module )->getModulePath( $module, 'forms');
		
		foreach ( $paths as $path ) {
			include_once( $path . $file . '.php' );
		}
		
		if (! isset( self :: $forms[$module . '.' . $file] ) ) {
			self :: $forms[$module . '.' . $file]	=	array();
		}
		
		$this->parseForm( $form, $module . '.' . $file );
		
		//self :: $forms[$module . '.' . $file] = $this->parseForm( $form, $module );
		//echo '<pre>'.print_r( self :: $forms, 1 );die();
		return self :: $forms[$module . '.' . $file];
	}
	
	
	/**
	 * Parses a form array and creates an array of objects
	 * @access		protected
	 * @version		@fileVers@
	 * @param		array		- $fields: an array of fields to parse
	 * @param		string		- $module: the module we are coming from
	 * 
	 * @return		array of objects
	 * @since		1.0.0
	 */
	protected function parseForm( $fields = array(), $moduleform = null )
	{
		// Cycle through our fields and add them in
		foreach ( $fields as $name => $field ) {
			$this->addField( $name, $field, $moduleform );
		}
		
		// Return our form (some modules expect the array of objects back)
		return self :: $forms[$moduleform];
	}
	
	
	public function render( $options = array() )
	{
		$data	= array();
		
		foreach ( $this->fields as $name => $field ) {
			$fop	= ( isset( $options['field'] ) ? $options['field'] : array() );
			$lop	= ( isset( $options['label'] ) ? $options['label'] : array() );
			$dop	= ( isset( $options['description'] ) ? $options['description'] : array() );
			$data[]	= (object) array( 'field' => $field->render( $fop ), 'label' => $field->label( $lop ), 'description' => $field->description( $dop ) );
		}
		
		return $data;
	}
	
	
	public function setAttribute( $item, $name, $value )
	{
		if (! isset( $this->fields[$item] ) ) return;
		$this->fields[$item]->setAttribute( $name, $value );
	}
	
	
	public function setAttributes( $fields = array(), $attrs = array() )
	{
		foreach ( $fields as $item => $vals ) {
			foreach ( $attrs as $name => $value ) {
				$this->setAttribute( $item, $name, $value );
			}
		}
	}
	
	
	public function setGroup( $groupname = null, $form = null )
	{
		if (! isset( self :: $forms[$form] ) ) {
			$parts = explode( '.', $form );
			$this->loadForm( $parts[1], $parts[0] );
		}
		
		$fields = self :: $forms[$form];
		
		foreach ( $fields as $name => $field ) {
			$fields[$name]->set( 'group', $groupname );
		}
		
		self :: $forms[$form] = $fields;
	}
	
	/**
	 * Method to set a setting to a form field
	 * @access		@public
	 * @version		@fileVers@
	 * @param		string		- $item: the field to set
	 * @param		mixed		- $value: the value to set
	 * @param		string		- $form: the form to apply to
	 * @param		string		- $setting: what we are setting (value|attribute|options|etc)
	 * 
	 * @return		instance of DunForm
	 * @since		1.0.0
	 */
	public function setItem( $item, $value, $form = null, $setting = 'value' )
	{
		if (! isset( self :: $forms[$form] ) ) {
			$parts = explode( '.', $form );
			$this->loadForm( $parts[1], $parts[0] );
		}
	
		$fields = self :: $forms[$form];
	
		if ( array_key_exists( $item, $fields ) ) {
			$method = 'set' . ucfirst( $setting );
			$fields[$item]->$method( $value );
		}
	
		self :: $forms[$form] = $fields;
	
		// Permit chaining to the main instance
		return self :: $instance;
	}
	
	
	/**
	 * Method to set settings to a form
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $values: the values to set
	 * @param		string		- $form: the form name (ie module.form )
	 * @param		string		- setting: what we are setting (value|attribute|options|etc)
	 * 
	 * @return		Corresponding DunFields object
	 * @since		1.0.0
	 */
	public function setItems( $values = array(), $form = null, $setting = 'value' )
	{
		if (! isset( self :: $forms[$form] ) ) {
			$parts = explode( '.', $form );
			$this->loadForm( $parts[1], $parts[0] );
		}
		
		$fields = self :: $forms[$form];
		
		// Catch instances of an object
		if ( is_object( $values ) ) {
			$values = get_object_vars( $values );
		}
		
		foreach ( $fields as $name => $field ) {
			if (! array_key_exists( $name, $values ) ) continue;
			$method = 'set' . ucfirst( $setting );
			$fields[$name]->$method( $values[$name]  );
		}
	
		self :: $forms[$form] = $fields;
	
		return self :: $forms[$form];
	}
	
	
	/**
	 * Shortcut method to set a option array to a form field
	 * @access		@public
	 * @version		@fileVers@
	 * @param		string		- $item: the field to set
	 * @param		mixed		- $value: the value to set
	 * @param		string		- $form: the form to apply to
	 *
	 * @return		instance of DunForm
	 * @since		1.0.0
	 */
	public function setOption( $item, $value, $form = null )
	{
		return $this->setItem( $item, $value, $form, 'option' );
	}
	
	
	/**
	 * Shortcut Method to set option array to ALL fields in a form
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $values: the values to set
	 * @param		string		- $form: the form name (ie module.form )
	 *
	 * @return		corresponding DunFields object
	 * @since		1.0.0
	 */
	public function setOptions( $values = array(), $form = null )
	{
		return $this->setItems( $values, $form, 'option' );
	}
	
	
	/**
	 * Shortcut method to set a value to a form field
	 * @access		@public
	 * @version		@fileVers@
	 * @param		string		- $item: the field to set
	 * @param		mixed		- $value: the value to set
	 * @param		string		- $form: the form to apply to
	 * 
	 * @return		instance of DunForm
	 * @since		1.0.0
	 */
	public function setValue( $item, $value, $form = null )
	{
		return $this->setItem( $item, $value, $form, 'value' );
	}
	
	
	/**
	 * Shortcut Method to set values to a form
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $values: the values to set
	 * @param		string		- $form: the form name (ie module.form )
	 * 
	 * @return		corresponding DunFields object
	 * @since		1.0.0
	 */
	public function setValues( $values = array(), $form = null )
	{
		return $this->setItems( $values, $form, 'value' );
	}
}