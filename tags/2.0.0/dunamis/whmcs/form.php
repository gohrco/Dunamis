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
 * Dunamis Form handler for WHMCS
 * @desc		This creates and manages HTML forms from WHMCS for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunForm extends DunForm
{
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
		parent :: __construct();
	}
	
	
	/**
	 * Method to load a form
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $extension: the name of the extension requesting
	 * @param		string		- $file: the filename to get
	 * @param		integer		- $type: the defined type
	 * 
	 * @since		1.0.0
	 */
	public function loadFormold( $extension = null, $file = null, $type = 0 )
	{
		if ( $extension == null || $file == null ) return;
		
		static $requested	= array();
		if ( isset( $requested[$extension][$file] ) ) return $requested[$extension][$file];
		if (! isset( $requested[$extension] ) ) $requested[$extension] = array();
		
		$instance	= new self( array() );
		$form		= $instance->_readFile( $extension, $file, $type );
		
		$instance->parseForm( $form, $extension, $type, $file );
		
		$requested[$extension][$file] = $instance;
// 		$form	= $this->_readFile( $extension, $file, $type );
// 		$this->parseForm( $form, $extension, $type, $file );
		
		return $requested[$extension][$file];
	}
	
	
	/**
	 * Method to read a file and provide a repository in case we need to call it many times
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $extension: the name of the extension requesting
	 * @param		string		- $file: the filename to get
	 * @param		integer		- $type: the defined type
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	private function _readFile( $extension, $file, $type )
	{
		static $requested	= array();
		if ( isset( $requested[$extension][$file] ) ) return $requested[$extension][$file];
		if (! isset( $requested[$extension] ) ) $requested[$extension] = array();
		
		$path		= WhmcsGoFDefines :: getPaths( $type ) . $extension . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR;
		$filename	= $path . $file . '.php';
	
		if (! file_exists( $filename ) ) {
			$form = array();
		}
		else {
			include( $filename );
		}
	
		$requested[$extension][$file] = $form;
		return $requested[$extension][$file];
	}
}