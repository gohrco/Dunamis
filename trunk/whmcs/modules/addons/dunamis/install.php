<?php
/**
 * @projectName@
 * Dunamis - Install Module Base File
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.3.3
 *
 * @desc       This file is the install controller
 *
 */

/**
 * Install Module Class for Integrator 3
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.3.3
 */
class DunamisInstallDunModule extends WhmcsDunModule
{
	private $destinationpath;
	private $files				=	array();
	private $sourcepath;
	
	/**
	 * Performs module activation
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.3.3
	 */
	public function activate()
	{
		// Load the database handler
		$db	= dunloader( 'database', true );
		
		// Load the initial tables
		$db->handleFile( 'sql' . DIRECTORY_SEPARATOR . 'install.sql', 'dunamis' );
		
		// Now we need to insert the settings
		$table = $this->_getTablevalues();
		
		foreach ( $table as $key => $value ) {
			$db->setQuery( "SELECT * FROM `mod_dunamis_settings` WHERE `key`=" . $db->Quote( $key ) );
			if ( $db->loadResult() ) continue;
			
			$db->setQuery( "INSERT INTO `mod_dunamis_settings` ( `key`, `value` ) VALUES (" . $db->Quote( $key ) . ", " . $db->Quote( $value ) . " )" );
			$db->query();
		}
	}
	
	
	/**
	 * Method for cycling through files to check for updated / modified files
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @return		array of objects
	 * @since		1.3.3
	 */
	public function checkFiles( $tpl = null )
	{
		$files	=	$this->_getTemplatefiles( $tpl );
		$css	=	$this->_getTemplatefiles( $tpl, 'css' );
		$js		=	$this->_getTemplatefiles( $tpl, 'js' );
		$files	=	array_merge( $files, $css, $js );
		sort( $files );
		
		foreach ( $files as $file ) {
			
			$tmp	=	(object) array(
					'current'	=>	false,
					'error'		=>	false,
					'code'		=>	0,
					);
			
			if ( $this->_isFilesizesame( $file ) ) {
				$tmp->current = true;
				$this->files[$file]	=	$tmp;
				continue;
			}
			
			// Read files
			$source	=	file_exists( $this->sourcepath . $file )		? @file( $this->sourcepath . $file ) : false;
			$dest	=	file_exists( $this->destinationpath . $file )	? @file( $this->destinationpath . $file ) : false;
			
			// Catch errors reading
			if (! $source || ! $dest ) {
				$tmp->code			=	(! $source ? 1 : 4 );
				$tmp->error			=	t( 'dunamis.install.file.error.read', ( ! $source ? 'source' : 'existing template' ) );
				$this->files[$file]	=	$tmp;
				continue;
			}
			
			// Find versions of files
			$sv	=
			$dv	=	false;
			
			foreach( array( 'sv' => 'source', 'dv' => 'dest' ) as $holder => $item ) {
				foreach ( $$item as $s ) {
					if ( preg_match( '/@version\s+([0-9\.]+)/im', $s, $matches, PREG_OFFSET_CAPTURE ) ) {
						$$holder	=	$matches[1][0];
						break;
					}
				}
			}
			
			// Ensure we found versions
			if (! $dv || ! $sv ) {
				$tmp->code			=	2;
				$tmp->error			=	t( 'dunamis.install.file.error.version', ( ! $sv ? 'source' : 'existing template' ) );
				$this->files[$file]	=	$tmp;
				continue;
			}
			
			// Do our comparisons
			if ( version_compare( $dv, $sv, 'lt' ) ) {
				$tmp->code			=	4;
				$tmp->error			=	t( 'dunamis.install.file.error.newer', ucfirst( t( 'dunamis.install.file.dunamis' ) ), t( 'dunamis.install.file.template' ) );
			}
			else if ( version_compare( $dv, $sv, 'gt' ) ) {
				$tmp->code			=	8;
				$tmp->error			=	t( 'dunamis.install.file.error.newer', ucfirst( t( 'dunamis.install.file.template' ) ), t( 'dunamis.install.file.dunamis' ) );
			}
			else {
				$tmp->current		=	true;
			}
			
			$this->files[$file]	=	$tmp;
		}
		
		return $this->files;
	}
	
	
	/**
	 * Method to deactivate the product
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * 
	 * @since		1.3.3
	 */
	public function deactivate()
	{
		// Load the database handler
		$db		=	dunloader( 'database', true );
		$config	=	dunloader( 'config', 'dunamis' );
		
		// Run the uninstall sql
		if (! $config->get( 'preservedb', false ) ) {
			$db->handleFile( 'sql' . DIRECTORY_SEPARATOR . 'uninstall.sql', 'dunamis' );
		}
		
		// Template time
		$files			=	$this->_getTemplatefiles( null, 'bak' );
		
		foreach ( $files as $file ) {
			
			// Since we have an array of .bak files, we need to figure the actual filename
			$actualfile	=	str_replace( '.bak', '', $file );
			
			// Use the original 'bak' file as it should be our first one
			$backupfile	=	$this->sourcepath . $file;
			
			// Move the current file to the source position
			@unlink( $this->destinationpath . $actualfile );
				
			// Move the backup file to the current position
			@rename( $backupfile, $this->destinationpath . $actualfile );
		}
	}
	
	
	/**
	 * Method for moving a single file into place
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $file: subpath of the file / filename to handle
	 *
	 * @return		boolean
	 * @since		1.3.3
	 */
	public function fixFile( $file )
	{
		// Watch for the first backups (original files)
		if ( file_exists( $this->sourcepath . $file . '.bak' ) ) {
			$backupfile	=	$this->sourcepath . $file . '.' . DUN_MOD_INTEGRATOR;
		
			// Be sure this isn't some sort of issue
			if ( file_exists( $backupfile ) ) {
				@unlink( $backupfile );
			}
		}
		else {
			$backupfile	=	$this->sourcepath . $file . '.bak';
		}
		
		// We may be putting new files in place... so be sure the destination is there before renaming it
		if ( file_exists( $this->destinationpath . $file ) ) {
			// Move the current file into the backup position
			@rename( $this->destinationpath . $file, $backupfile );
		}
			
		// Move the new to current position
		@copy( $this->sourcepath . $file, $this->destinationpath . $file );
		
		return true;
	}
	
	
	/**
	 * Method to get the table settings for a given table
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $table: the table to get
	 *
	 * @return		array
	 * @since		1.3.3
	 */
	public function getConfiguration( $table = 'settings' )
	{
		return $this->_getTablevalues( $table );
	}
	
	
	/**
	 * Initializes the module
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @since		1.3.3
	 */
	public function initialise()
	{
		// Template time
		$this->sourcepath		=	dirname( __FILE__ ) . DIRECTORY_SEPARATOR
								.	'templates' . DIRECTORY_SEPARATOR
								.	get_version() . DIRECTORY_SEPARATOR;
		$this->destinationpath	=	DUN_ENV_PATH
								.	'templates'	. DIRECTORY_SEPARATOR;
		
	}
	
	
	/**
	 * Method to handle a legacy upgrade
	 * @access		public
	 * @version		@fileVers@ ( $id$ )
	 *
	 * @since		1.3.3
	 */
	public function legacy()
	{
		// First lets go ahead and run the activation routine
		$this->activate();
		
		// Load the database handler
		$db		=	dunloader( 'database', true );
		$config	=	dunloader( 'config', 'dunamis' );
		
		$map	=	array(
				'DebugErrors'			=>	array( 'name'	=> 'debug',				'type'	=>	'bool' ),
		);
		
		foreach ( $map as $old => $new ) {
			// Let's load our old settings now
			$db->setQuery( "SELECT `value` FROM `tbladdonmodules` WHERE `module`=" . $db->Quote( 'dunamis' ) . ' AND `setting` = ' . $db->Quote( $old ) );
			$value	=	$db->loadResult();
			
			if ( $new['type'] == 'bool' ) {
				$value = ( $value == 'Yes' ? true : false );
			}
			
			$config->set( $new['name'], $value );
		}
		
		$config->save();
		return;
	}
	
	
	/**
	 * Method to get the legacy files for deletion
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		boolean		- $sendDirs: if we want the directories back
	 * 
	 * @return		array
	 * @since		1.3.3
	 */
	private function _getLegacyfiles( $sendDirs = false )
	{
		return array();
	}
	
	
	/**
	 * Method to get the table values
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $config: which table to get for
	 * 
	 * @return		array
	 * @since		1.3.3
	 */
	private function _getTablevalues( $config = 'settings' )
	{
		$data	= array();
		switch ( $config ) :
		case 'settings' :
			$data	= array(
					'updates'	=> null,
					
					// General Settings
					'debug'			=>	false,
					);
		break;
		endswitch;
		
		return $data;
	}
	
	
	/**
	 * Method to gather tpl files for moving around
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $subdir: any recursive subdirs
	 * @param		string		- $type: indicates what we are looking for [tpl|bak]
	 *
	 * @return		array
	 * @since		1.3.3
	 */
	private function _getTemplatefiles( $subdir = null, $type = 'tpl' )
	{
		$files	=	array();
		$path	=	$this->sourcepath
				.	$subdir;
		
		$dh	=	scandir( $path );
		
		foreach ( $dh as $file ) {
			if ( in_array( $file, array( '.', '..', 'custom.css', 'custom.css.new' ) ) ) continue;
			if ( is_dir( $path . $file ) ) {
				$files	=	array_merge( $files, $this->_getTemplatefiles( $subdir . $file . DIRECTORY_SEPARATOR, $type ) );
				continue;
			}
			$info	=	pathinfo( $file );
			if ( $info['extension'] != $type ) continue;
			$files[]	=	$subdir . $file;
		}
		
		return $files;
	}
	
	
	/**
	 * Method for testing if the file size is the same
	 * @access		private
	 * @version		@fileVers@ ( $id$ )
	 * @param		string		- $file: relative path to file
	 *
	 * @return		bool
	 * @since		1.3.3
	 */
	private function _isFilesizesame( $file = null )
	{
		// If the destination doesnt exist it cant be the same
		if (! file_exists( $this->destinationpath . $file ) ) {
			return false;
		}
		return md5_file( $this->sourcepath . $file ) == md5_file( $this->destinationpath . $file );
	}
}