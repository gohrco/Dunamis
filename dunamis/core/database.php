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
 * Dunamis Core Database File
 * @desc		This is the core database handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunDatabase extends DunObject
{
	/**
	 * Contains the resulting database cursor
	 * @access		private
	 * @version		@fileVers@
	 * @var			object
	 */
	private $_cursor	= null;
	
	/**
	 * Contains the limiting value
	 * @access		private
	 * @version		@fileVers@
	 * @var			integer
	 */
	private $_limit		= 0;
	
	/**
	 * Contains the offset value
	 * @access		private
	 * @version		@fileVers@
	 * @var			integer
	 */
	private $_offset	= 0;
	
	/**
	 * Stores the database resource when connected
	 * @access		protected
	 * @var			object
	 * @since		1.0.0
	 */
	protected $_resource	= null;
	
	/**
	 * Contains the sql query to execute
	 * @access		private
	 * @version		@fileVers@
	 * @var			string
	 */
	private $_sql		= null;
	
	/**
	 * When parsing a SQL file this is used to split multiple commands up
	 * @access		private
	 * @var			string
	 * @since		1.0.0
	 */
	private $_linedelimiter	= '-- command split --';
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @version		1.0.8		- March 2013: Object construction moved here for environment
	 * @param		array		- $options: contains an array of arguments
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		// Lets use friendlier names (why not?)
		$hostname	=	$options['hostname'];
		$username	=	$options['username'];
		$password	=	$options['password'];
		$database	=	$options['database'];
		
		// Create the resource and connect
		$this->_resource = @mysql_connect( $hostname, $username, $password, true );
		mysql_select_db( $database, $this->_resource );
	}
	
	
	/**
	 * Determines how many rows were affected by the previous query
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		integer of number of affected rows
	 * @since		3.0.0
	 */
	public function getAffectedRows()
	{
		return mysql_affected_rows( $this->_resource );
	}
	
	
	/**
	 * Escapes a field value
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $text: contains the string to escape
	 * @param		boolean		- $extra: if set will also slash '%' and'_' values
	 *
	 * @return		escaped string for query
	 * @since		1.0.0
	 */
	public function getEscaped( $text, $extra = false )
	{
		$result = mysql_real_escape_string( $text, $this->_resource );
		if ( $extra ) {
			$result = addcslashes( $result, '%_' );
		}
		return $result;
	}
	
	
	/**
	 * Returns the id of the last insert query
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		integer of last inserted row
	 * @since		3.0.0
	 */
	public function getInsertid()
	{
		return mysql_insert_id( $this->_resource );
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @version		1.0.8		- March 2013: Possibility of multiple databases being instantiated included
	 * @param		array		- $options: contains an array of arguments
	 * 
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = array();
		
		// See if we are passing along arguments otherwise assume environment
		if ( empty( $options ) ) {
			$database	=	'environment';
		}
		else {
			$database	=	md5( serialize( $options ) );
		}
		
		// See if we have been here before
		if (! isset( $instance[$database] ) || ! is_object( $instance[$database] ) ) {
			
			// Base class
			$classname	= 'DunDatabase';
			
			// If we want the environment, then see if it exists
			if ( $database == 'environment' ) {
				
				if ( defined( 'DUN_ENV' ) ) {
					$classname	= ucfirst( strtolower( DUN_ENV ) ) . 'DunDatabase';
				}
				
			}
			
			// Regardless, instantiate new object
			$instance[$database]	= new $classname( $options );
		}
		
		return $instance[$database];
	}
	
	
	/**
	 * Gets the number of rows queried
	 * @access		public
	 * @version		@fileVers@
	 * @param		resource		- $cur: If provided contains a database resource
	 *
	 * @return		integer of rows selected
	 * @since		3.0.0
	 */
	public function getNumRows( $cur = null )
	{
		return mysql_num_rows( $cur ? $cur : $this->_cursor );
	}
	
	
	/**
	 * Checks to see if the database is connected
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		3.0.0
	 */
	public function isConnected()
	{
		if ( is_resource( $this->_resource ) ) {
			return mysql_ping( $this->_resource );
		}
		return false;
	}
	
	
	/**
	 * Loads a single row of values from a result
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array of key => value pairs from the database
	 * @since		3.0.0
	 */
	public function loadAssoc()
	{
		if (! ( $cur = $this->query() ) ) return null;
		
		$ret = null;
		if ( $array = mysql_fetch_assoc( $cur ) )
			$ret = $array;
		
		mysql_free_result( $cur );
		
		return $ret;
	}
	
	
	/**
	 * Loads the rows of values from a result
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $key: if set will bind each row to the value of the key provided
	 * 
	 * @return		array of arrays containing key => value pairs from the database
	 * @since		3.0.0
	 */
	public function loadAssocList( $key = null )
	{
		if (!( $cur = $this->query() ) ) return null;
		
		$array = array();
		while ( $row = mysql_fetch_assoc( $cur ) ) {
			if ($key)
				$array[$row[$key]] = $row;
			else
				$array[] = $row;
		}
		
		mysql_free_result( $cur );
		
		return $array;
	}
	
	
	/**
	 * Loads a single object of values from the first row of a result
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		object containing key => value pairings from the database
	 * @since		3.0.0
	 */
	public function loadObject( )
	{
		if (! ( $cur = $this->query() ) ) return null;
		
		$ret = null;
		if ( $object = mysql_fetch_object( $cur ) )
			$ret = $object;
		
		mysql_free_result( $cur );
		
		return $ret;
	}
	
	
	/**
	 * Loads the rows of values into an array of objects from a result
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $key: if set will bind each row of objects to the value of the key provided
	 * 
	 * @return		array of objects containing key->value pairs from the database
	 * @since		3.0.0
	 */
	public function loadObjectList( $key='' )
	{
		if (!( $cur = $this->query() ) ) return null;
		
		$array = array();
		while ( $row = mysql_fetch_object( $cur ) ) {
			if ( $key )
				$array[$row->$key] = $row;
			else
				$array[] = $row;
		}
		
		mysql_free_result( $cur );
		
		return $array;
	}
	
	
	/**
	 * Loads a single column of the first row of a result, regardless of number of columns
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing the result value
	 * @since		3.0.0
	 */
	public function loadResult()
	{
		// Execute the query
		if (! ( $cur = $this->query() ) ) return null;
		
		$ret = null;
		if ( $row = mysql_fetch_row( $cur ) )
			$ret = $row[0];
		
		mysql_free_result( $cur );
		
		return $ret;
	}
	
	
	/**
	 * Loads a single column of values of a result, regardless of number of rows or columns returned
	 * @access		public
	 * @version		@fileVers@
	 * @param		integer		- $numinarray: if provided will return the offset values from the row (defaults to first column)
	 * 
	 * @return		array containing values from the database
	 * @since		3.0.0
	 */
	public function loadResultArray( $numinarray = 0 )
	{
		if (! ( $cur = $this->query() ) ) return null;
		
		$array = array();
		while ( $row = mysql_fetch_row( $cur ) )
			$array[] = $row[$numinarray];
		
		mysql_free_result( $cur );
		
		return $array;
	}
	
	
	/**
	 * Wrapper for loadResultArray
	 * @access		public
	 * @version		@fileVers@
	 * @param		integer		- $numinarray: if provided will return the offset values from the row (defaults to first column)
	 * 
	 * @return		result of loadResultArray
	 * @since		3.0.0
	 */
	public function loadResultList( $numinarray = 0 )
	{
		return $this->loadResultArray( $numinarray );
	}
	
	
	/**
	 * Loads a single row from the database result
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		array of values from the database
	 * @since		3.0.0
	 */
	public function loadRow()
	{
		if (!( $cur = $this->query() ) ) return null;
		
		$ret = null;
		if ( $row = mysql_fetch_row( $cur ) )
			$ret = $row;
		
		mysql_free_result( $cur );
		
		return $ret;
	}
	
	
	/**
	 * Loads the rows from the database result
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $key: if set will bind each result to the value of the key provided
	 * 
	 * @return		array of values from the database
	 * @since		3.0.0
	 */
	public function loadRowList( $key = null )
	{
		if (!( $cur = $this->query() ) ) return null;
		
		$array = array();
		while ( $row = mysql_fetch_row( $cur ) ) {
			if ($key !== null)
				$array[$row[$key]] = $row;
			else
				$array[] = $row;
		}
		
		mysql_free_result( $cur );
		
		return $array;
	}
	
	
	/**
	 * Ensures a name is properly quoted for querying
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $s: contains the table field name to quote
	 *
	 * @return		string containing quoted field (unless table.field provided)
	 * @since		1.0.0
	 */
	public function nameQuote( $s )
	{
		// Only quote if the name is not using dot-notation
		if ( strpos( $s, '.' ) === false ) {
			return "`{$s}`";
		}
		else {
		return $s;
		}
	}
		
	
	/**
	 * Parses a file given a path
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $path: contains the full path and filename to parse
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	public function parseFile( $path )
	{
		if (! file_exists( $path ) ) return array();
		
		ob_start();
			include( $path );
			$buffer = ob_get_contents();
		ob_end_clean();
		
		if ( empty( $buffer ) ) return array();
		
		$commands	= explode( $this->_linedelimiter, $buffer );
		$data		= array();
		
		foreach ( $commands as $command ) {
			$data[]	= trim( $command );
		}
		
		return $data;
	}
	
	
	/**
	 * Executes a query set in the database object
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		resource object or false on failure
	 * @since		1.0.0
	 */
	public function query()
	{
		// If not even a resource then end
		if (! is_resource( $this->_resource ) ) return false;
	
		$sql = $this->_sql; // Local copy
	
		if ($this->_limit > 0 || $this->_offset > 0) {
			$sql .= ' LIMIT ' . max($this->_offset, 0) . ', ' . max($this->_limit, 0);
		}
	
		$this->_cursor = mysql_query( $sql, $this->_resource );
		
		dunloader( 'debug', true )->addQuery( $sql );
		
		// If this failed
		if (!$this->_cursor)
		{
			$this->setError( mysql_errno( $this->_resource ) . ': ' . mysql_error( $this->_resource )." SQL=$sql" );
			return false;
		}
	
		return $this->_cursor;
	}
	
	
	/**
	 * Ensures a value is quoted and escaped for querying
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $text: contains the value to quote
	 * @param		boolean		- $escaped: if true, escapes the value else uses as is
	 *
	 * @return		string containing quoted and or escaped string
	 * @since		1.0.0
	 */
	public function Quote( $text, $escaped = true )
	{
		return '\''.($escaped ? $this->getEscaped( $text ) : $text).'\'';
	}
	
	
	/**
	 * Sets the query to the database object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $sql: containing the query
	 * @param		integer		- $limit: if set, will set the maximum number of rows to return
	 * @param		integer		- $offset: if set, will set where to start from
	 *
	 * @since		1.0.0
	 */
	public function setQuery( $sql, $limit = 0, $offset = 0 )
	{
		$this->_sql		= $sql;
		$this->_limit	= (int) $limit;
		$this->_offset	= (int) $offset;
	}
	
	
	/**
	 * Handles errors for the database object
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $msg: contains the error string
	 * 
	 * @since		1.0.2
	 */
	public function setError( $msg )
	{
		$dun = & get_dunamis();
		$dun->setError( DUN_ERROR, $msg );
	}
}