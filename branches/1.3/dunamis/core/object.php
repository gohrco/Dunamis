<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Dunamis Object File
 * This is the core object file - everything is built upon it
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
 * Dunamis Object class
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.0
 */
class DunObject
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: anything we want to set
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		
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
	 * @since		1.2.0
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
	 * Method to retrieve the called class
	 * @static
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		string
	 * @since		1.2.1
	 */
	public static function get_called_class()
	{
		// Rely on Late Static Binds for 5.3+
		if ( version_compare( PHP_VERSION, '5.3', 'ge' ) ) {
			return get_called_class();
		}
	
		// 5.2 and below
		$btArray	=	debug_backtrace();
	
		foreach ( $btArray as $bt ) {
			if ( __METHOD__ == $bt['function'] ) continue;
			if (! isset( $bt['line'] ) || ! isset( $bt['file'] ) ) continue;
			if ( empty( $bt['args'] ) ) continue;
			if ( strpos( $bt['args'][0], 'getInstance' ) === false ) continue;
			if ( strpos( $bt['args'][0], '::' ) === false ) continue;
			$parts	=	explode( '::', $bt['args'][0] );
			$called	=	$parts[0];
			break;
		}
	
		return $called;
	}
}