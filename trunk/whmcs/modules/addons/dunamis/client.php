<?php defined('DUNAMIS') OR exit('No direct script access allowed');

if (! defined( 'DUN_MOD_DUNAMIS' ) ) define( 'DUN_MOD_DUNAMIS', "@fileVers@" );

/**
 * Dunamis Client Class
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.0
 */
class DunamisClientDunModule extends WhmcsDunModule
{
	/**
	 * Stores the type of module this is
	 * @access		protected
	 * @var			string
	 * @since		1.0.0
	 */
	protected $type	= 'addon';
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		parent :: __construct( $options );
		
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.0.0
	 */
	public function initialise()
	{
		dunloader( 'language', true )->loadLanguage( 'dunamis' );
	}
}