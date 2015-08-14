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
 * Dunamis Core Archive File
 * @desc		This is the core Archive handler of the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunArchive extends DunObject
{
	protected $_ctrldirend	=	"\x50\x4b\x05\x06\x00\x00\x00\x00";	// Used by non-native file info read
	protected $_ctrldirhead	=	"\x50\x4b\x01\x02";					// Used by non-native file info read
	protected $_error		=	null;
	protected $_exceptions	=	array();
	protected $_fileheader	=	"\x50\x4b\x03\x04";
	protected $_metadata	=	null;	// Used by the non-native zip extracter
	protected $_methods		=	array( 0x0 => 'None', 0x1 => 'Shrunk', 0x2 => 'Super Fast', 0x3 => 'Fast', 0x4 => 'Normal', 0x5 => 'Maximum', 0x6 => 'Imploded', 0x8 => 'Deflated');
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $options: anything we want to set
	 * 
	 * @since		1.0.10
	 */
	public function __construct( $options = array() )
	{
		$options	=	$this->setProperties( array(), $options );
		return $options;
	}
	
	
	/**
	 * Getter / Setter / Haser function
	 * @desc		Use by calling getUrl() or setUrl('value') to get/set $this->_url
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $name: the method invoked
	 * @param		mixed		- $arguments: any arguments passed along
	 *
	 * @return		mixed
	 * @since		1.0.10
	 */
	public function __call( $name, $arguments )
	{
		if ( strpos( $name, 'get' ) !== false && strpos( $name, 'get' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^get#", '', $name ) );
			return $this->$var;
		}
		
		if ( strpos( $name, 'set' ) !== false && strpos( $name, 'set' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^set#", '', $name ) );
			$value		=	array_shift( $arguments );
			
			if ( $var == '_exceptions' ) {
				if (! is_array( $value ) ) $value = array( $value );
				$prev	=	$this->getExceptions();
				$value	=	array_merge( $prev, $value );
			}
			
			$this->$var	=	$value;
			return $this;
		}
		
		if ( strpos( $name, 'has' ) !== false && strpos( $name, 'has' ) == 0 ) {
			$var	=	'_' . strtolower( preg_replace( "#^has#", '', $name ) );
			$value	=	(bool) ( isset( $this->$var ) && ! empty( $this->$var ) );
			return $value;
		}
	}
	
	
	/**
	 * Extract a file into a directory
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $archive: the archive path and filename to extract
	 * @param		string		- $directory: where we wanna put it
	 *
	 * @return		boolean
	 * @since		1.0.10
	 */
	public function extract( $archive, $directory )
	{
		$extension	=	$this->_getExtension( $archive );
		
		// Permit extendability here
		switch ( $extension ) :
		case 'zip' :
			return $this->_zipExtract( $archive, $directory );
			break;
		endswitch;
	}
	
	
	
	/**
	 * Method to put contents into the file / path
	 * @access		protected
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $file: the filename or mixed path / filename to store into
	 * @param		mixed		- $data: the content to store
	 * @param		string		- $path: the base path we are starting from
	 *
	 * @return		boolean
	 * @since		1.0.10
	 */
	protected function filePutcontents( $file, $data, $path = null )
	{
		if ( $path == null ) {
			$path = ( is_defined( 'DUN_ENV_PATH' ) ? DUN_ENV_PATH : DUN_PATH );;
		}
		
		$file	=	preg_replace( '#[/\\\\]+#', DIRECTORY_SEPARATOR, $file );
		$path	=	rtrim( $path, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
		
		$dirs	=	explode( DIRECTORY_SEPARATOR, dirname( $file ) );
		$dpath	=	$path;
		
		while ( ( $dir = array_shift( $dirs ) ) ) {
			if (! is_dir( $dpath . $dir ) ) {
				if (! @mkdir( $dpath . $dir ) ) {
					return false;
				}
			}
			
			$dpath .= $dir . DIRECTORY_SEPARATOR;
		}
		
		return @file_put_contents( $path . $file, $data );
	}
	
	
	/**
	 * Gets the extension of a file
	 * @access		protected
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $filename: contains the filename
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	protected function _getExtension ( $filename )
	{
		$dot	=	strrpos( $filename, '.') + 1;
		return substr( $filename, $dot );
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.10
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
	
		if (! is_object( $instance ) ) {
			
			$classname	=	'DunArchive';
			
			if ( defined( 'DUN_ENV' ) ) {
				$envclassname = ucfirst( strtolower( DUN_ENV ) ) . $classname;
				
				if ( class_exists( $envclassname ) ) {
					$classname = $envclassname;
				}
			}
			
			$instance = new $classname( $options );
		}
	
		return $instance;
	}
	
	
	/**
	 * Determines if a file is permitted or disallowed
	 * @access		protected
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $file: the filename w/ path to check [t|f]
	 *
	 * @return		boolean
	 * @since		1.0.10
	 */
	protected function isAllowed( $file )
	{
		$exceptions	=	$this->getExceptions();
		return (! in_array( $file, $exceptions ) ? true : false );
	}
	
	
	/**
	 * Method to set properties for an object
	 * @access		protected
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $properties: any properties to cycle through
	 * @param		array		- $options: the options array passed to us
	 *
	 * @return		array
	 * @since		1.0.10
	 */
	protected function setProperties( $properties, $options )
	{
		foreach ( $properties as $item ) {
			if ( isset( $options[$item] ) ) {
				$meth = 'set' . ucfirst( $item );
				$this->$meth( $options[$item] );
				unset( $options[$item] );
			}
		}
		return $options;
	}
	
	
	/**
	 * Extracts a zip archive
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $archive: path and filename to archive
	 * @param		string		- $destination: path to destination
	 *
	 * @return		boolean result
	 * @since		1.0.10
	 */
	private function _zipExtract( $archive, $destination )
	{
		if (! is_file( $archive ) ) {
			$this->setError( 'Archive name provided is not a file' );
			return false;
		}
		
		if ( $this->_zipNative() ) {
			return $this->_zipExtractFileNative( $archive, $destination );
		}
		else {
			return $this->_zipExtractFile( $archive, $destination ); 
		}
	}
	
	
	/**
	 * Method to extract a file if not compiled with ZIP library
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $archive: path and filename to archive
	 * @param		string		- $destination: path to destination
	 *
	 * @return		boolean result
	 * @since		1.0.10
	 */
	private function _zipExtractFile( $archive, $destination )
	{
		$data	=	null;
		
		if (! extension_loaded( 'zlib' ) ) {
			$this->setError( 'Zip extraction is not supported on your system' );
			return false;
		}
		
		if (! $data = file_get_contents( $archive ) ) {
			$this->setError( 'Unable to read archive' );
			return false;
		}
		
		if (! $this->_zipReadinfo( $data ) ) {
			$this->setError( 'Zip information retrieval failed' );
			return false;
		}
		
		// Cycle through the meta
		$metadata	=	(array) $this->getMetadata();
		
		for ( $i = 0, $n = count( $metadata ); $i < $n; $i++ ) {
			$lastPathCharacter	=	substr( $metadata[$i]['name'], -1, 1 );
			
			if ( $lastPathCharacter !== '/' && $lastPathCharacter !== '\\' ) {
				if (! $this->isAllowed( $metadata[$i]['name'] ) ) continue;
				$buffer =	$this->_zipGetFileData( $i, $data );
				
				if ( ( $this->filePutcontents( $metadata[$i]['name'], $buffer, $path ) ) === false ) {
					$this->setError( 'Unable to write entry' );
					return false;
				}
			}
		}
		
		return true;
	}
	
	
	/**
	 * Method to extract a file if compiled with ZIP library
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $archive: path and filename to archive
	 * @param		string		- $destination: path to destination
	 *
	 * @return		boolean result
	 * @since		1.0.10
	 */
	private function _zipExtractFileNative( $archive, $destination )
	{
		$zip	=	zip_open($archive);
		if ( is_resource( $zip ) ) {
			
			// Lets ensure our destination exists
			if (! is_dir( $destination ) ) {
				if (! @mkdir( $destination ) ) {
					$this->setError( 'Unable to create destination `' . $destination . '`' );
					return false;
				}
			}
			
			while ( $file = @zip_read( $zip ) ) {
				
				if (! $this->isAllowed( zip_entry_name( $file ) ) ) continue;
				if ( zip_entry_open( $zip, $file, "r" ) ) {
					if ( substr( zip_entry_name( $file ), strlen( zip_entry_name( $file ) ) - 1 ) != "/" ) {
						$buffer	=	zip_entry_read( $file, zip_entry_filesize( $file ) );
						
						if ( $this->filePutcontents( zip_entry_name( $file ), $buffer, $destination ) === false ) {
							$this->setError( 'Unable to write entry to destination ' . zip_entry_name( $file ) );
							return false;
						}
						
						zip_entry_close( $file );
					}
				}
				else {
					$this->setError( 'Unable to read entry' );
					return false;
				}
			}
			
			@zip_close( $zip );
		}
		else {
			$this->setError( 'Unable to open archive' );
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * Method to get the file data from a zip archive
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $key: the key in the method array to use
	 * @param		varies		- $data: the data being sent us
	 *
	 * @return		string
	 * @since		1.0.10
	 */
	private function _zipGetFileData( $key, $data )
	{
		$metadata	=	$this->getMetadata();
		
		if ( $metadata[$key]['_method'] == 0x8 ) {
			return gzinflate( substr( $data, $metadata[$key]['_dataStart'], $metadata[$key]['csize'] ) );
		}
		else if ( $metadata[$key]['_method'] == 0x0 ) {
			/* Files that aren't compressed. */
			return substr( $data, $metadata[$key]['_dataStart'], $metadata[$key]['csize'] );
		}
		else if ( $metadata[$key]['_method'] == 0x12 ) {
			// Is bz2 extension loaded?  If not try to load it
			if (! extension_loaded( 'bz2' ) ) {
				
				if ( DUN_OS_ISWIN ) {
					@dl( 'php_bz2.dll' );
				}
				else {
					@dl( 'bz2.so' );
				}
			}
			
			// If bz2 extension is successfully loaded use it
			if ( extension_loaded( 'bz2' ) ) {
				return bzdecompress( substr( $data, $metadata[$key]['_dataStart'], $metadata[$key]['csize'] ) );
			}
		}
		
		return '';
	}
	
	
	/**
	 * Method to determine native zip support
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		boolean
	 * @since		1.0.10
	 */
	private function _zipNative()
	{
		return (function_exists('zip_open') && function_exists('zip_read'));
	}
	
	
	/**
	 * Reads the zip archive and compiles the meta data of the various files
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		array		- $data: the data array
	 *
	 * @return		boolean
	 * @since		1.0.10
	 */
	private function _zipReadinfo( $data )
	{
		// Lets init
		$entries		=	array();
		$offset			=	0;
		$ctrldirend		=	$this->getCtrldirend();
		$ctrldirhead	=	$this->getCtrldirhead();
		$fhLast			=	strpos( $data, $ctrldirend );
		
		do {
			$last = $fhLast;
		}
		while ( ( $fhLast = strpos( $data, $ctrldirend, $fhLast + 1 ) ) !== false );
		
		if ( $last ) {
			$endOfCentralDirectory = unpack(
					'vNumberOfDisk/vNoOfDiskWithStartOfCentralDirectory/vNoOfCentralDirectoryEntriesOnDisk/' .
					'vTotalCentralDirectoryEntries/VSizeOfCentralDirectory/VCentralDirectoryOffset/vCommentLength',
					substr( $data, $last + 4 )
			);
			$offset = $endOfCentralDirectory['CentralDirectoryOffset'];
		}
		
		// Get details from central directory structure.
		$fhStart	=	strpos( $data, $ctrldirhead, $offset );
		$dataLength	=	strlen( $data );
		$methods	=	$this->getMethods();
		$fileheader	=	$this->getFileheader();
		
		do {
			if ( $dataLength < $fhStart + 31 ) {
				$this->setError( 'Invalid zip data' );
				return false;
			}
			
			$info	=	unpack( 'vMethod/VTime/VCRC32/VCompressed/VUncompressed/vLength', substr( $data, $fhStart + 10, 20 ) );
			$name	=	substr( $data, $fhStart + 46, $info['Length'] );
			
			$entries[$name] = array(
				'attr'			=>	null,
				'crc'			=>	sprintf( "%08s", dechex( $info['CRC32'] ) ),
				'csize' 		=>	$info['Compressed'],
				'date'			=>	null,
				'_dataStart'	=>	null,
				'name'			=>	$name,
				'method'		=>	$methods[$info['Method']],
				'_method'		=>	$info['Method'],
				'size'			=>	$info['Uncompressed'],
				'type'			=>	null
			);
			
			$entries[$name]['date'] = mktime(
					( ( $info['Time'] >> 11 ) & 0x1f ),
					( ( $info['Time'] >> 5 ) & 0x3f ),
					( ( $info['Time'] << 1 ) & 0x3e ),
					( ( $info['Time'] >> 21 ) & 0x07 ),
					( ( $info['Time'] >> 16) & 0x1f),
					( ( ( $info['Time'] >> 25 ) & 0x7f ) + 1980 )
			);
			
			if ( $dataLength < $fhStart + 43 ) {
				$this->setError( 'Invalid ZIP data' );
				return false;
			}
			
			$info = unpack('vInternal/VExternal/VOffset', substr($data, $fhStart + 36, 10));
			
			$entries[$name]['type'] 	=	( $info['Internal'] & 0x01 ) ? 'text' : 'binary';
			$entries[$name]['attr'] 	=	( ( $info['External'] & 0x10 ) ? 'D' : '-' ) . ( ( $info['External'] & 0x20 ) ? 'A' : '-' )
										.	( ( $info['External'] & 0x03 ) ? 'S' : '-' ) . ( ( $info['External'] & 0x02 ) ? 'H' : '-' )
										.	( ( $info['External'] & 0x01 ) ? 'R' : '-' );
			$entries[$name]['offset']	=	$info['Offset'];
			
			// Get details from local file header since we have the offset
			$lfhStart = strpos( $data, $fileheader, $entries[$name]['offset'] );
			
			if ( $dataLength < $lfhStart + 34 ) {
				$this->setError( 'Invalid ZIP Data' );
				return false;
			}
			
			$info	=	unpack( 'vMethod/VTime/VCRC32/VCompressed/VUncompressed/vLength/vExtraLength', substr( $data, $lfhStart + 8, 25 ) );
			$name	=	substr( $data, $lfhStart + 30, $info['Length'] );
			
			$entries[$name]['_dataStart']	=	$lfhStart + 30 + $info['Length'] + $info['ExtraLength'];
			
			// Bump the max execution time because not using the built in php zip libs makes this process slow.
			@set_time_limit( ini_get( 'max_execution_time' ) );
		}
		
		while ( ( ( $fhStart = strpos( $data, $ctrldirhead, $fhStart + 46 ) ) !== false ) );
		
		$this->setMetadata( array_values( $entries ) );
		
		return true;
	}
}