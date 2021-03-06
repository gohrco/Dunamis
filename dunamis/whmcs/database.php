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
 * Dunamis Database handler for WHMCS
 * @desc		This works with the database from WHMCS for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunDatabase extends DunDatabase
{
	/**
	 * Constructor Method
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- June 2016: Change over to PDO usage
	 * @version		1.0.8		- March 2013: Database construction moved to parent
	 * @param		array		- $options: contains an array of arguments
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		// Include the WHMCS configuration file
		include( DUN_ENV_PATH . 'configuration.php' );
		
		// Setup the options array
		$options['hostname']	=	$db_host;
		$options['username']	=	$db_username;
		$options['password']	=	$db_password;
		$options['database']	=	$db_name;
		
		// Construct the object
		parent :: __construct( $options );
	}
	
	
	/**
	 * Given a filename and extension and type parse and execute commands
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $filename: the relative path and filename
	 * @param		string		- $extension: the extension name
	 * 
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function handleFile( $filename, $extension = null )
	{
		$path	= WhmcsDunModule :: locateModule( $extension ) . $filename;
		
		if (! file_exists( $path ) ) return false;
		
		$commands = $this->parseFile( $path );
		
		foreach ( $commands as $sql ) {
			$this->setQuery( $sql );
			$this->query();
		}
		
		return true;
	}
}