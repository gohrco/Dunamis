<?php
/**
 * @projectName@
 *
 * @package    @packageName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      3.1.00
 *
 * @desc       This file is the configuration handler for Integrator 3
 *
 */

defined('DUNAMIS') OR exit('No direct script access allowed');


/**
 * Configuration Class for Dunamis
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		3.1.00
 */
class Com_dunamisDunConfig extends JoomlaDunConfig
{
	protected $_map	=	array();
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		3.1.00
	 */
	public function __construct()
	{
		parent :: __construct();
	}
	
	
	/**
	 * Method to find the appropriate language to use
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $joomlang: contains a Joomla language string (ie en-GB, es-ES etc or default)
	 *
	 * @return		string
	 * @since		3.1.00
	 */
	public function findLanguage( $joomlang = 'default' )
	{
		if ( isset( $this->_map[$joomlang] ) && $this->_map[$joomlang] != '0' ) {
			return $this->_map[$joomlang];
		}
		
		if ( isset( $this->_map[$joomlang] ) && $this->_map[$joomlang] == '0' ) {
			return $this->_map['default'];
		}
		
		return $this->_map[$joomlang];
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		3.1.00
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
			
			$instance = new Com_dunamisDunConfig( $options );
		}
	
		return $instance;
	}
	
	
	/**
	 * Method to gather values for the form to work from
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		boolean		- $reload: if we need to reload to ensure we have latest
	 * 
	 * @return		array
	 * @since		3.1.00
	 */
	public function getValues( $reload = false )
	{
		// If we reload, then do so
		if ( $reload ) {
			$this->load();
		}
		
		$params		=	JComponentHelper :: getParams( 'com_dunamis' )->toArray();
		$vars		=	get_object_vars( $this );
		
		foreach ( $params as $k => $v ) {
			
			// Let's handle our language values
			if ( $k == 'jwhmcslanguage' ) {
				$params[$k] = $this->_getLanguagevalues( $v );
				unset( $vars[$k] );
				continue;
			}
			
			if ( isset( $vars[$k] ) ) {
				$params[$k] = $vars[$k];
				unset( $vars[$k] );
			}
		}
		
		foreach ( $vars as $k => $v ) {
			$params[$k] = $vars[$k];
		}
		
		return $params;
	}
	
	
	/**
	 * Loader method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		3.1.00
	 */
	public function load()
	{
		$params	=	JComponentHelper :: getParams( 'com_dunamis' )->toArray();
		
		foreach ( $params as $k => $v ) {
			
			// Handle languages
			if ( $k == 'integratorlanguage' ) {
				$this->_loadLanguages( $v );
				continue;
			}
			
			$this->set( $k, $v );
		}
	}
	
	
	/**
	 * Save method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		3.1.00
	 */
	public function save()
	{
		$table	=	JTable::getInstance( 'extension' );
		$origin	=	$table->find( array( 'element' => 'com_dunamis', 'type' => 'component' ) );
		
		if (! $table->load( $origin ) ) {
			return $table->getError();
		}
		
		if (! $table->bind( array( 'params' => $this->getValues() ) ) ) {
			return $table->getError();
		}
		
		if (! $table->check() ) {
			return $table->getError();
		}
		
		if (! $table->store() ) {
			return $table->getError();
		}
		
		return true;
	}
}