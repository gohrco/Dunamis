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
 * Dunamis Hooks handler for Wordpress
 * @desc		This interacts with hook points in Wordpress for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Wordpress
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunHooks extends DunHooks
{
	/**
	 * Executes a hook point
	 * @access		public
	 * @version		@fileVers@
	 * @param		
	 * @param		string		- $extension: contains the calling extension to avoid conflicts
	 * 
	 * @since		1.5.0
	 */
	public function execute( $hookpoint, $extension, $type, $vars = array() )
	{
		static	$base = array();
		
		$paths		= array(
						'base' => DUN_PATH . DIRECTORY_SEPARATOR . strtolower( DUN_ENV ) . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR,
						'extension' => get_dunamis( $extension )->getModulePath( $extension, 'hooks' )
					);
		
		$contents	=	null;
		$contarray	=	array();
		
		foreach ( $paths as $is => $path ) {
			// Weed out the type we are executing (to avoid running twice)
			if ( $is != $type ) continue;
			
			// If we have already run the base hookpoint dont do it again
			if ( $is == 'base' && isset( $base[$hookpoint] ) ) continue;
			
			// Set so we don't do this again for base ones
			if ( $is == 'base' ) {
				$base[$hookpoint] = true;
			}
			
			// Obviously if the file doesn't exist that would be bad
			if (! file_exists( $path . $hookpoint . '.php' ) ) continue;
			
			include( $path . $hookpoint . '.php' );
			
		}
	}
	
	
	/**
	 * Sets the extension name in place
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: the name of the extension
	 *
	 * @since		1.5.0
	 * @param unknown_type $name
	 */
	public function setExtension( $name = null )
	{
		parent :: setExtension( $name );
	}
	
	
	/**
	 * Attach hooks to the system
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $extension: the name of the module to attach to
	 * @param		integer		- $usepriority: if set we will use this priority when setting
	 * 
	 * @since		1.5.0
	 */
	public function attachHooks( $extension = null, $usepriority = 0 )
	{
		static 	$priority	= 500;
		static	$attached	= array();
		
		if ( isset( $attached[$extension] ) ) return;
		else $attached[$extension] = true;
		
		$paths		= array(
						'base' => DUN_PATH . DIRECTORY_SEPARATOR . strtolower( DUN_ENV ) . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR,
						'extension' => get_dunamis( $extension )->getModulePath( $extension, 'hooks' )
					);
		
		foreach ( $paths as $type => $path ) {
			$dh	=	opendir( $path );
			
			while( false !== ( $file = readdir( $dh ) ) ) {
				if ( in_array( $file, array( '.', '..', 'index.html' ) ) ) continue;
				$hookname	=	str_replace( '.php', '', $file );
				
				$functionname	=	"dunamis_{$extension}_{$type}_{$hookname}";
				$newfunction	=	<<< CODE
				
				function {$functionname}() {
					return dunloader( 'hooks', true )->execute( '{$hookname}', '{$extension}', '{$type}' );
				}
CODE;
				eval( $newfunction );
				add_action( $hookname, $functionname );
			}
		}
		
		return;
	}
}