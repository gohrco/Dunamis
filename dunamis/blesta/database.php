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
 * Dunamis Database class for Blesta
 * @desc		This is the database handler for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class BlestaDunDatabase extends DunDatabase
{
	/**
	 * Constructor Method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 * 
	 * @since		1.3.0
	 */
	public function __construct( $options = array() )
	{
		$dbvals	=	(object) \Configure :: get ( 'Blesta.database_info' );
		
		// Setup the options array
		$options['hostname']	=	$dbvals->host;
		$options['username']	=	$dbvals->user;
		$options['password']	=	$dbvals->pass;
		$options['database']	=	$dbvals->database;
		
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
	 * @since		1.3.0
	 */
	public function handleFile( $filename, $extension = null )
	{
		$path	= BlestaDunModule :: locateModule( $extension ) . $filename;
		
		if (! file_exists( $path ) ) return false;
		
		$commands = $this->parseFile( $path );
		
		foreach ( $commands as $sql ) {
			$this->setQuery( $sql );
			$this->query();
		}
		
		return true;
	}
}