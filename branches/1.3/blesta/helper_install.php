<?php
/**
 * Dunamis Framework
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
 * Dunamis Installation Helper
 * @desc		This file is a helper file used to install the Dunamis Framework on Blesta
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class DunHelper
{
	
	/**
	 * Method to apply the modifications needed to the structure files for Blesta
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$content		Contains our original pdt content
	 * 
	 * @return		string						Modified pdt content
	 * @since		1.3.0
	 */
	public static function applyDunamisMods( $content )
	{
		$regexes	=	self :: _getRegexes();
		
		foreach ( $regexes as $regex ) {
			preg_match_all( $regex->find, $content, $matches );
			$content = preg_replace( $regex->find, $regex->repl, $content );
		}
		
		return $content;
	}
	
	
	/**
	 * Method to change the file extension for a path/file
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$file		The path/filename to work on
	 * @param		string		$ext		The new extension to use [bak]
	 * @param		boolean		$ow			Indicates we should overwrite an existing file w/ the new extension [TRUE|false]
	 * @param		boolean		$move		Indicates we want to move the file not copy it [TRUE|false]
	 * 
	 * @return		boolean
	 * @since		1.3.0
	 */
	public static function changeFileExtension( $file, $ext = 'bak', $ow = true, $move = true )
	{
		$parsed		=	pathinfo( $file );
		
		$newfile	=	substr( $file, 0, ( -1 * strlen( $parsed['extension'] ) ) ) . $ext;
		
		// Unable to overwrite
		if ( file_exists( $newfile ) && ! $ow ) {
			return false;
		}
		else {
			unlink ( $newfile );
		}
		
		if ( $move ) {
			rename( $file, $newfile );
		}
		else {
			if ( function_exists( 'copy' ) ) {
				copy( $file, $newfile );
			}
			// work around for disabled copy
			else {
				$contentx	=	@file_get_contents( $file );
				$openedfile	=	fopen( $newfile, "w");
				fwrite( $openedfile, $contentx );
				fclose( $openedfile );
				
				if ( $contentx === FALSE ) {
					return false;
				}
			}
		}
		
		return true;
	}
	
	
	/**
	 * Retrieve files given the name and extension sought
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$name		The name of the file to search (without extension)
	 * @param		string		$ext		The file extension we are searching for
	 * 
	 * @return		array					An array of filenames with full paths matching the name and extension sought
	 * @since		1.3.0
	 */
	public static function getFiles( $name = 'structure', $ext = 'pdt' )
	{
		$paths	=	self :: _readDirectories();
		$files	=	array();
		$name	=	$name . '.' . $ext;
		
		foreach ( $paths as $path ) {
			if (! file_exists( $path . $name ) ) continue;
			if ( is_readable( $path . $name ) ) {
				$files[]	=	$path . $name;
			}	
		}
		
		return $files;
	}
	
	
	/**
	 * Method to read a file
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$file		The path/file to read
	 * 
	 * @return		string|false			Either the contents of the file or false on failure
	 * @since		1.3.0
	 */
	public static function readFile( $file )
	{
		if ( file_exists( $file ) && is_readable( $file ) && function_exists( 'file_get_contents' ) ) {
			return file_get_contents( $file );
		}
		
		return false;
	}
	
	
	/**
	 * Method to write to a file
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$file		The path/file to write to
	 * @param		string		$content	The content of the new file
	 * @param		boolean		$ow			Indicates we should overwrite an existing file [true|FALSE]
	 * 
	 * @return		boolean
	 * @since		1.3.0
	 */
	public static function writeFile( $file, $content, $ow = false )
	{
		if ( file_exists( $file ) && $ow === false ) {
			return false;
		}
		
		return file_put_contents( $file, $content );
	}
	
	
	/**
	 * Gets the regular expressions to run against pdt files
	 * @static
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @return		array of objects		Objects contain the regex and replacement
	 * @since		1.3.0
	 */
	private static function _getRegexes()
	{
		$data	=	array();
		
		$data[]	=	(object) array(
			'find'	=>	"#(<head>)#i",
			'repl'	=>	"\$1\n\t<?php echo dunloader('document', true)->renderMetaData() ?>"
		);
		
		$data[]	=	(object) array(
			'find'	=>	"#(<\/title>)#i",
			'repl'	=>	"\$1\n\t<?php echo dunloader( 'document', true )->renderHeadData() ?>"
		);
		
		$data[]	=	(object) array(
				'find'	=>	"#(<\/body>)#i",
				'repl'	=>	"<?php echo dunloader( 'document', true )->renderFootData() ?>\n\t\$1"
		);
		
		return $data;
	}
	
	
	/**
	 * Method to read directories for directories recursively
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		$dir		The directory to walk [VIEWDIR]
	 * 
	 * @return		array					Contains an array of directories found
	 * @since		1.3.0
	 */
	private static function _readDirectories( $dir = VIEWDIR )
	{
		$dh		=	opendir( $dir );
		$dirs	=	array();
		
		while ( false !== ( $entry = readdir( $dh ) ) ) {
			if ( in_array( $entry, array( '.', '..' ) ) ) continue;
			if ( is_dir( $dir . $entry ) ) {
				$dirs[]		=	$dir . $entry . DIRECTORY_SEPARATOR;
				$subdirs	=	self :: _readDirectories( $dir . $entry . DIRECTORY_SEPARATOR );
				foreach ( $subdirs as $sub ) $dirs[]	=	$sub;
				continue;
			}
		}
		
		return $dirs;
	}
}