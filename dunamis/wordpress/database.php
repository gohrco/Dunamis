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

defined( 'DUNAMIS' ) OR exit('No direct script access allowed');

/**
 * Dunamis Database class for Joomla
 * @desc		This grabs database handler from Wordpress for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Wordpress
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunDatabase extends DunDatabase
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
	 * @since		1.1.0
	 */
	public function __construct( $options = array() )
	{
		// Setup the options array
		$options['hostname']	=	DB_HOST;
		$options['username']	=	DB_USER;
		$options['password']	=	DB_PASSWORD;
		$options['database']	=	DB_NAME;
		
		$this->_prefix			=	$GLOBALS['table_prefix'];
		
		// Construct the object
		parent :: __construct( $options );
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