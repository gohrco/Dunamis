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
	 * @param		array		- $properties: contains an array of arguments
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $properties = array() )
	{
		parent :: __construct( $properties );
		
		// Connect to the database set in the configuration file
		include( DUN_ENV_PATH . 'configuration.php' );
		$this->_resource = @mysql_connect( $db_host, $db_username, $db_password, true );
		mysql_select_db( $db_name, $this->_resource );
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