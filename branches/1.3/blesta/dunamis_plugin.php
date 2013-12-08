<?php
/**
 * Dunamis Framework
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
 * DunamisPlugin
 * @desc		This is the plugin file for the Dunamis Framework Plugin
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunamisPlugin extends Plugin
{
	
	/**
	 * Constructor Method
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.3.0
	 */
	public function __construct()
	{
		//Loader :: loadComponents( $this, array( 'Input' ) );
	}
	
	
	/**
	 * Method to get events attachable to the framework
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return      array		an array of arrays containing event / callback pairs
	 * @since		1.3.0
	 */
	public function getEvents()
	{
		return 
			array(
				array(
					'event' => "Appcontroller.preAction",
					'callback' => array("this", "init" )
				)
				// Add multiple events here
			);
	}
	
	
	/**
	 * Method to get the logo of the plugin
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string			Contains the path to the logo
	 * @since		1.3.0
	 */
	public function getLogo()
	{
		return	'dunamis' . DIRECTORY_SEPARATOR . 
				'core' . DIRECTORY_SEPARATOR .
				'assets' . DIRECTORY_SEPARATOR .
				'img' . DIRECTORY_SEPARATOR  .
				"dunamis-48.png";
	}
	
	
	/**
	 * Method to get the name of the plugin
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string			Indicating the name of the product
	 * @since		1.3.0
	 */
	public function getName()
	{
		return "Dunamis Framework";
	}
	
	
	/**
	 * Method to get the version of the product
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string			Indicating the version of the product
	 * @since		1.3.0
	 */
	public function getVersion()
	{
		return '@fileVers@';
	}
	
	
	/**
	 * Method to get the authors of the product
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array			Containing the name and URL of the authors  
	 * @since		1.3.0
	 */
	public function getAuthors()
	{
		return
			array(
				array(
						'name'	=>	'@packageAuth@',
						'url'	=>	'@packageLink@'
				)
		);
	}
	
	
	/**
	 * AppController.preAction Callback method
	 * @desc		Used to ensure the Dunamis Framework is initiated on the system
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.3.0
	 */
	public function init()
	{
		// Get and require file
		$path	=	dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'dunamis.php';
		require_once $path;
		
		// Initialize Dunamis
		try {
			get_dunamis();
		}
		catch ( Exception $e ) {
			$this->Input->setErrors( array( 'dunamis'=> array( 'message' => $e->getMessage() ) ) );
		}
	}
	
	
	/**
	 * Method to handle any install tasks
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$plugin_id		The plugin id we are assigned
	 *
	 * @since		1.3.0
	 */
	public function install( $plugin_id )
	{
		require_once 'helper_install.php';
		
		// Installation Tasks To Perform
		//     * Get a list of files to change
		//     * Copy original to bak
		//     * Edit structure.pdt files to load up our Dunamis Document handler items
		
		// Gather list of files
		$pdts	=	array_merge( DunHelper :: getFiles( 'structure' ), DunHelper :: getFiles( 'structure_admin_login' ) );
		
		foreach ( $pdts as $pdt ) {
				
			// Read our file
			if ( false === ( $content = DunHelper :: readFile( $pdt ) ) ) {
				continue;
			}
				
			// Rename the file
			DunHelper :: changeFileExtension( $pdt, 'jblesta-bak' );
				
			// Apply our changes and save
			$content = DunHelper :: applyDunamisMods( $content );
			DunHelper :: writeFile( $pdt, $content );
		}
	}
	
	
	/**
	 * Method to handle any uninstall tasks
	 * @access		public
	 * @version		1.3.0
	 * @param		string		$plugin_id		The plugin id we are assigned
	 * @param		boolean		$last_instance	Indicates this it the last instance of our plugin
	 *
	 * @since		1.3.0
	 */
	public function uninstall( $plugin_id, $last_instance )
	{
		require_once 'helper_install.php';
		
		// Uninstallation Tasks To Perform
		//     * Get a list of files to change back
		//     * Swap jblesta-bak / pdt files
		//     * Delete .jblesta-bak files
		
		// Gather list of files
		$pdts	=	array_merge( DunHelper :: getFiles( 'structure', 'jblesta-bak' ), DunHelper :: getFiles( 'structure_admin_login', 'jblesta-bak' ) );
		
		// Do the work
		foreach ( $pdts as $pdt ) {
			DunHelper :: changeFileExtension( $pdt, 'pdt' );
		}
	}
	
	
	/**
	 * Method to handle any upgrade tasks
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$current_version	The currently installed version of Dunamis
	 * @param		string		$plugin_id			The plugin id we are assigned
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function upgrade( $current_version, $plugin_id )
	{
		
	}
}