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
	 * Contains arguments passed by setQuery for executing PDO statements
	 * @access		private
	 * @version		@fileVers@
	 * @var			array
	 */
	private $_arguments = array();
	
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
	 * Stores our connection options so we can reconnect
	 * @access		protected
	 * @var			array
	 * @since		2.0.0
	 */
	private $_options	=	array();
	
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
	 * @version		2.0.0		- May 2016: Updated for PHP7
	 * @version		1.0.8		- March 2013: Object construction moved here for environment
	 * @param		array		- $options: contains an array of arguments
	 * 
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		$this->init( $options );
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
		return $this->getNumRows();
	}
	
	
	/**
	 * Escapes a field value
	 * @deprecated
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
		dunloader( 'debug', true )->addInfo( 'Database :: getEscaped is deprecated' );
		
		if (! empty( $text ) && is_string( $text ) ) {
			$text = str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $text);
			if ( $extra ) {
				$text	=	addcslashes( $text, '%_' );
			}
		}
		
		return $text;
	}
	
	
	/**
	 * Returns the id of the last insert query
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Convert to PDO
	 *
	 * @return		integer of last inserted row
	 * @since		1.0.0
	 */
	public function getInsertid()
	{
		return $this->_resource->lastInsertId();
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
	 * @version		2.0.0		- May 2016: Convert to PDO
	 * @param		resource	- $cur: If provided contains a database resource
	 *
	 * @return		integer of rows selected
	 * @since		3.0.0
	 */
	public function getNumRows( $cur = null )
	{
		if (! $this->_cursor ) {
			$this->setError( 'Database :: getNumRows: No query has been executed' );
			return 0;
		}
		
		return $this->_cursor->rowCount();
	}
	
	
	/**
	 * Method to initialize our object
	 * @access		public
	 * @version		@fileVers@
	 * @param unknown $options
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function init( $options = array() )
	{
		if ( empty( $options ) ) {
			$options	=	$this->_options;
		}
		else {
			$this->_options	=	$options;
		}
		
		// Lets use friendlier names (why not?)
		$hostname	=	$options['hostname'];
		$username	=	$options['username'];
		$password	=	$options['password'];
		$database	=	$options['database'];
		
		// Create the resource and connect
		try {
			$this->_resource	=	new PDO( "mysql:host=$hostname;dbname=$database", $username, $password);
			return true;
		}
		catch(PDOException $e) {
			return $e->getMessage();
		}
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
		if ( is_a( $this->_resource, 'PDO' ) ) {
			
			try {
				$this->_resource->query( 'SELECT 1' );
			}
			catch ( PDOException $e ) {
				return false;
			}
			return true;
		}
		
		return false;
	}
	
	
	/**
	 * Loads a single row from the database result
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Convert to PDO
	 *
	 * @return		array of values from the database
	 * @since		1.0.0
	 */
	public function loadAssoc()
	{
		if (! $this->query() ) return array();
	
		$row	=	$this->_cursor->fetch( \PDO :: FETCH_ASSOC );
	
		if ( $row ) {
			return $row;
		}
	
		return array();
	}
	
	
	/**
	 * Loads the rows from the database result
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Convert to PDO
	 * @param		string		- $key: if set will bind each result to the value of the key provided
	 *
	 * @return		array of values from the database
	 * @since		1.0.0
	 */
	public function loadAssocList( $key = null )
	{
		if (! $this->query() ) return array();
	
		$rows	=	$this->_cursor->fetchAll( \PDO :: FETCH_ASSOC );
	
		if ( $rows ) {
			return $rows;
		}
	
		return array();
	}
	
	
	/**
	 * Loads a single object of values from the first row of a result
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Update to PDO
	 * 
	 * @return		object containing key => value pairings from the database
	 * @since		3.0.0
	 */
	public function loadObject( )
	{
		if (! $this->query() ) return array();
		
		$row	=	$this->_cursor->fetch( \PDO :: FETCH_OBJ );
		
		if ( $row ) {
			return $row;
		}
		
		return array();
	}
	
	
	/**
	 * Loads the rows of values into an array of objects from a result
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Update to PDO
	 * @param		string		- $key: if set will bind each row of objects to the value of the key provided
	 * 
	 * @return		array of objects containing key->value pairs from the database
	 * @since		3.0.0
	 */
	public function loadObjectList( $key='' )
	{
		if (! $this->query() ) return array();
		
		$rows	=	$this->_cursor->fetchAll( \PDO :: FETCH_OBJ );
		
		if ( $rows ) {
			return $rows;
		}
		
		return array();
	}
	
	
	/**
	 * Loads a single column of the first row of a result, regardless of number of columns
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Convert to PDO
	 * 
	 * @return		string containing the result value
	 * @since		1.0.0
	 */
	public function loadResult()
	{
		if (! $this->query() ) return array();
		
		$row	=	$this->loadRow();
		$data	=	null;
		
		if ( $row ) {
			$data	=	$row[0];
		}
		
		return $data;
	}
	
	
	/**
	 * Loads a single column of values of a result, regardless of number of rows or columns returned
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Convert to PDO
	 * @param		integer		- $numinarray: if provided will return the offset values from the row (defaults to first column)
	 * 
	 * @return		array containing values from the database
	 * @since		3.0.0
	 */
	public function loadResultArray( $numinarray = 0 )
	{
		if (! $this->query() ) return array();
		
		$data	=	array();
		while ( $item = $this->_cursor->fetchColumn( $numinarray ) ) {
			$data[]	=	$item;
		}
		
		return $data;
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
	 * @version		2.0.0		- May 2016: Convert to PDO
	 * 
	 * @return		array of values from the database
	 * @since		1.0.0
	 */
	public function loadRow()
	{
		if (! $this->query() ) return array();
		
		$row	=	$this->_cursor->fetch( \PDO :: FETCH_BOTH );
		
		if ( $row ) {
			return $row;
		}
		
		return array();
	}
	
	
	/**
	 * Loads the rows from the database result
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Convert to PDO
	 * @param		string		- $key: if set will bind each result to the value of the key provided
	 * 
	 * @return		array of values from the database
	 * @since		1.0.0
	 */
	public function loadRowList( $key = null )
	{
		if (! $this->query() ) return array();
		
		$rows	=	$this->_cursor->fetchAll( \PDO :: FETCH_BOTH );
		
		if ( $rows ) {
			return $rows;
		}
		
		return array();
	}
	
	
	/**
	 * Ensures a name is properly quoted for querying
	 * @deprecated
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $s: contains the table field name to quote
	 *
	 * @return		string containing quoted field (unless table.field provided)
	 * @since		1.0.0
	 */
	public function nameQuote( $s )
	{
		dunloader( 'debug', true )->addInfo( 'Database :: nameQuote is deprecated' );
		return $s;
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
	 * @version		2.0.0		- May 2016: Convert to PDO
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function query()
	{
		// If not even a resource then end
		if (! $this->isConnected() ) return false;
		
		// See if we already have a prepared statement
		if ( $this->_cursor ) return true;
		
		// Prepare a statement using our query from setQuery then
		$sql = $this->_sql; // Local copy
	
		if ($this->_limit > 0 || $this->_offset > 0) {
			$sql .= ' LIMIT ' . max($this->_offset, 0) . ', ' . max($this->_limit, 0);
		}
		
		dunloader( 'debug', true )->addQuery( $sql, $this->_arguments );
		
		try {
			$this->_cursor	=	$this->_resource->prepare( $sql );
			$this->_cursor->execute( $this->_arguments );
		}
		catch( \PDOException $e ) {
			dunloader( 'debug', true )->addError( $e->getMessage() );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Ensures a value is quoted and escaped for querying
	 * @deprecated
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
		dunloader( 'debug', true )->addInfo( 'Database :: Quote is deprecated' );
		
		return '\''.($escaped ? $this->getEscaped( $text ) : $text).'\'';
	}
	
	
	/**
	 * Sets the query to the database object
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Update for PDO handling
	 * @param		string		- $sql: containing the query
	 * @param		mixed		- contains either an integer for backwards compatability or an array for PDO
	 * @param		mixed		- contains either an integer for backwards compatability or is empty
	 *
	 * @return		boolean
	 * @since		1.0.0
	 */
	public function setQuery( $sql, $limit = 0, $offset = 0 )
	{
		if (! $sql ) return false;
		
		if ( is_integer( $limit ) ) {
			// Be sure to reset arguments
			$this->_arguments	=	array();
			$this->_limit	= (int) $limit;
			$this->_offset	= (int) $offset;
		}
		else {
			$this->_arguments	=	(array) $limit;	// Can be an array now
		}
		
		$this->_cursor	=	null;
		$this->_sql		=	$sql;
		
		return true;
	}
	
	
	/**
	 * Handles errors for the database object
	 * @access		public
	 * @version		@fileVers@
	 * @version		2.0.0		- May 2016: Using debug handler for error now
	 * @param		string		- $msg: contains the error string
	 * 
	 * @return		boolean
	 * @since		1.0.2
	 */
	public function setError( $msg )
	{
		return dunloader( 'debug', true )->addError( $msg );
	}
}