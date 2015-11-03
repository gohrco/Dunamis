<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @projectName@
 * Integrator 3 - Configuration Handler File
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.5.0
 *
 * @desc       This file is the configuration handler
 *
 */


/**
 * Configuration Class for Dunamis
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.4.0
 */
class DunamisDunConfig extends WordpressDunConfig
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.5.0
	 */
	public function __construct()
	{
		parent :: __construct();
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.5.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
			$instance = new DunamisDunConfig( $options );
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
	 * @since		1.5.0
	 */
	public function getValues( $reload = false )
	{
		// If we reload, then do so
		if ( $reload ) {
			$this->load();
		}
		
		$configs	=	dunmodule( 'dunamis.settings' )->getFields();
		$vars		=	get_object_vars( $this );
		
		foreach ( $configs as $k => $v ) {
			$configs[$k]	= ( isset( $vars[$k] ) ? $vars[$k] : $v );
		}
		
		return $configs;
	}
}