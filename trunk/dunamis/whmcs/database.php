<?php


/**
 * WhmcsGoFDatabase Object
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.0.0
 */
class WhmcsDunDatabase extends DunDatabase
{
	/**
	 * Constructor Method
	 * @access		public
	 * @version		@fileVers@
	 * @version		1.0.8		- March 2013: Database construction moved to parent
	 * @param		array		- $options: contains an array of arguments
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		// ---- BEGIN INTOUCH-5 / DUN-4
		//		Quote duplication is failing with In Touch activate
		global $whmcsmysql;
		
		if ( is_resource( $whmcsmysql ) ) {
			$this->_resource	= & $whmcsmysql;
			return;
		}
		// ---- END INTOUCH-5 / DUN-4
		
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