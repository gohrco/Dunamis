<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Joomla Dunamis Database File
 * This is the database handler of the Dunamis Framework
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
 * Joomla Dunamis Database class handler
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.1.0
 */
class JoomlaDunDatabase extends DunDatabase
{
	/**
	 * Prefix for the Joomla database table
	 * @version		@fileVers@
	 * @var			string
	 * @since		1.1.0
	 */
	protected	$_prefix	=	null;
	
	
	/**
	 * Constructor Method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		// Include the WHMCS configuration file
		@include_once( DUN_ENV_PATH . 'configuration.php' );
		
		$config	=	new JConfig();
		
		// Setup the options array
		$options['hostname']	=	$config->host;
		$options['username']	=	$config->user;
		$options['password']	=	$config->password;
		$options['database']	=	$config->db;
		
		$this->_prefix	=	$config->dbprefix;
		
		// Construct the object
		parent :: __construct( $options );
	}
	
	
	/**
	 * Given a filename and extension and type parse and execute commands
	 * @TODO:  Determine if we need to implement this file handler for Joomla
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
		return true;
		$path	= WhmcsDunModule :: locateModule( $extension ) . $filename;
		
		if (! file_exists( $path ) ) return false;
		
		$commands = $this->parseFile( $path );
		
		foreach ( $commands as $sql ) {
			$this->setQuery( $sql );
			$this->query();
		}
		
		return true;
	}
	
	
	/**
	 * Sets the query to the database object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $sql: containing the query
	 * @param		integer		- $limit: if set, will set the maximum number of rows to return
	 * @param		integer		- $offset: if set, will set where to start from
	 *
	 * @since		1.1.0
	 */
	public function setQuery( $sql, $limit = 0, $offset = 0 )
	{
		$sql	=	str_replace( '#__', $this->_prefix, $sql );
		parent :: setQuery( $sql, $limit, $offset );
	}
}