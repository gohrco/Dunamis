<?php
/**
 * @projectName@
 * 
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.1.0
 * 
 * @desc       This is the setup file for the Dunamis within Kayako
 * 
 */

/**
 * Setup Database Controller
 * @author		Steven
 * @version		@fileVers@
 * 
 * @since		1.1.0
 */
class SWIFT_SetupDatabase_dunamis extends SWIFT_SetupDatabase
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		true
	 * @since		1.1.0
	 */
	public function __construct()
	{
		parent::__construct("dunamis");
		return true;
	}
	
	
	/**
	 * Destructor method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		true
	 * @since		1.1.0
	 */
	public function __destruct()
	{
		parent::__destruct();
		return true;
	}
	
	
	/**
	 * Installation method
	 * @access		public
	 * @version		@fileVers@
	 * @param		unknown		- $_pageIndex: passed to parent install
	 * 
	 * @return		true
	 * @since		1.1.0
	 */
	public function Install($_pageIndex)
	{
		parent::Install($_pageIndex);
		$this->ImportSettings();
		return true;
	}
	
	
	/**
	 * Upgrade method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		true
	 * @since		1.1.0
	 */
	public function Upgrade()
	{
		$this->ImportSettings();
		return parent::Upgrade();
	}
	
	
	/**
	 * Uninstallation method
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		true
	 * @since		1.1.0
	 */
	public function Uninstall()
	{
		parent::Uninstall();
		return true;
	}
	
	
	/**
	 * Imports the settings from the xml manifest
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.1.0
	 */
	private function ImportSettings()
	{
		$this->Load->Library('Settings:SettingsManager');
		
		if ( version_compare( SWIFT_VERSION, '4.50', 'ge' ) ) {
			$this->SettingsManager->Import('./'.SWIFT_APPSDIRECTORY.'/dunamis/config/settings.xml');
		}
		else {
			$this->SettingsManager->Import('./'.SWIFT_MODULESDIRECTORY.'/dunamis/config/settings.xml');
		}
	}
	
}
?>