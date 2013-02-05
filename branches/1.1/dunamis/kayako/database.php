<?php


/**
 * KayakoDunDatabase Object
 * @version		@fileVers@
 * 
 * @author		Steven
 * @since		1.1.0
 */
class KayakoDunDatabase extends DunDatabase
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
		include_once( DUN_ENV_PATH . '__swift' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php' );
		$this->_resource = @mysql_connect( DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, true );
		mysql_select_db( DB_NAME, $this->_resource );
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
		$path	= KayakoDunModule :: locateModule( $extension ) . $filename;
		
		if (! file_exists( $path ) ) return false;
		
		$commands = $this->parseFile( $path );
		
		foreach ( $commands as $sql ) {
			$this->setQuery( $sql );
			$this->query();
		}
		
		return true;
	}
}