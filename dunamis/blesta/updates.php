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
 * Dunamis Updates class for Blesta
 * @desc		This manages updates for Blesta plugins and modules for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Blesta
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class BlestaDunUpdates extends DunUpdates
{
	protected $_check	=	true;
	protected $_force	=	false;
	protected $_lastrun	=	null;
	protected $_update	=	null;
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: anything we want to set
	 *
	 * @since		1.3.0
	 */
	public function __construct( $options = array() )
	{
		$options = parent :: __construct( $options );
		$options = $this->setProperties( array( 'check', 'force', 'lastrun', 'update' ), $options );
		return $options;
	}
	
	
	/**
	 * Method for downloading an update
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.3.0
	 */
	public function download()
	{
		$url	=	$this->_updateUrl();
		$target	=	$this->_updateTarget();
		
		return ( ( $result = $this->downloadAndStore( $url, $target ) ) !== false ? true : false );
	}
	
	
	/**
	 * Simple method for determining updates exist
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean or 'error' on problem
	 * @since		1.3.0
	 */
	public function exist()
	{
		$this->_updateFind();
		
		if ( $this->hasError() ) {
			return 'error';
		}
		else if ( $this->_updateCompare() ) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
	/**
	 * Method for downloading an update
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.3.0
	 */
	public function extract()
	{
		$archive	=	dunloader( 'archive', false );
		$archive->setExceptions( $this->getExceptions() );
		$archive->extract( $this->_updateTarget(), $this->getInstallpath() );
	
		return ( $archive->hasError() !== false ? true : false );
	}
	
	
	/**
	 * Method for getting the update target for locating the downloaded archive
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.3.0
	 */
	public function getUpdateTarget()
	{
		return $this->_updateTarget();
	}
	
	
	/**
	 * Method for downloading the update
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		void
	 * @since		1.0.0
	 */
	public function retrieveUpdate()
	{
		$url	=	$this->_updateUrl();
		$target	=	$this->_updateTarget();
		
		if ( ! ( $result = $this->downloadAndStore( $url, $target ) ) ) {
			return false;
		}
		
		$archive	=	dunloader( 'archive', false );
		$archive->setExceptions( $this->getExceptions() );
		$archive->extract( $this->_updateTarget(), $this->getInstallpath() );
	}
	
	
	/**
	 * Method for testing if an update exists
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string containing update or false on none
	 * @since		1.3.0
	 */
	public function updatesExist()
	{
		$this->_updateFind();
		
		if ( $this->_updateCompare() ) {
			return $this->_updateCompare( null, true );
		}
		else {
			return false;
		}
	}
	
	
	/**
	 * Method to compare two versions
	 * @access		protected
	 * @version		@fileVers@
	 * @param		stdClass		- $update: if we are comparing on the fly we can pass this along
	 * @param		boolean			- $getvers: if we want the most up to date version or bool response
	 *
	 * @return		boolean true on new update, false on not, null on no update found | string containing most recent version
	 * @since		1.3.0
	 */
	protected function _updateCompare( stdClass $update = null, $getvers = false )
	{
		if ( $update == null ) $update = $this->getUpdate();
		if ( $update == null ) return null; // Nothing to compare against
		
		// Compare last version to ours
		$v	=	str_replace( 'v', '', $update->version );
		
		if ( $getvers ) {
			return version_compare( $v, $this->getVersion(), 'g' ) ? $v : $this->getVersion();
		}
		else {
			return version_compare( $v, $this->getVersion(), 'g' );
		}
	}
	
	
	/**
	 * Method for testing the lastrun date
	 * @access		protected
	 * @version		@fileVers@
	 * @param		timestamp		- $lastrun: if we want to manually check a timestamp
	 *
	 * @return		boolean true on expired
	 * @since		1.3.0
	 */
	protected function _updateExpired( $lastrun = null )
	{
		if ( $lastrun == null ) $lastrun = $this->getLastrun();
		return $lastrun < time();
	}
	
	
	/**
	 * Method for finding an update
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.3.0
	 */
	protected function _updateFind()
	{
		if (! $this->getCheck() ) return false;
		
		if ( $this->getForce() || $this->_updateExpired() ) {
			
			$this->setForce( false );
			$response	=	$this->downloadAndReturn();
			
			if (! $response ) return false;
			
			libxml_use_internal_errors(true);
			$xml		= simplexml_load_string( $response );
			
			if ( $xml === false ) {
				
				$errors = null;
				foreach (libxml_get_errors() as $error) {
					$errors .= "\r\n" . $error;
				}
				
				libxml_clear_errors();
				
				$this->setError( $errors );
			}
			
			$data		= simpleXMLToArray( $xml );
			$latest		= null;
			
			// If we only have one update we must nest the update into another array
			if ( isset( $data['update'] ) && ! is_array( $data['update'][0] ) ) $data['update'] = array( $data['update'] );
			
			if ( isset( $data['update'] ) ) foreach ( $data['update'] as $res ) {
				if ( version_compare( $res['version'], $latest, 'g' ) ) {
					$latest		= $res['version'];
					$version	= json_decode( json_encode( $res ) );
				}
			}
			 
			$this
				->setLastrun( ( (int) time() + (int) $this->getExpires() ) )
				->setUpdate( $version )
				->_updateWrite();
		}
		
		return true;
	}
	
	
	/**
	 * Method for reading an update in
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.3.0
	 */
	protected function _updateRead()
	{
		
	}
	
	
	/**
	 * Method for getting the update target
	 * @access		protected
	 * @version		@fileVers@
	 * 
	 * @return		false on empty update
	 * @return		string
	 * @since		1.3.0
	 */
	protected function _updateTarget()
	{
		$url	=	$this->_updateUrl();
		
		if (! $url ) return false;
		
		$update		=	$this->getUpdate();
		$uri		=	DunUri :: getInstance( $url );
		$filename	=	array_pop( explode( '/', $uri->getPath() ) );
		$extension	=	( isset ( $update->downloads->downloadurl->format ) ? $update->downloads->downloadurl->format : 'ini' );
		$target		=	$this->getTarget() . $filename . '.' . $extension;
		
		return $target;
	}
	
	
	/**
	 * Method for getting a download URL for update
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		false on empty update
	 * @return		string
	 * @since		1.3.0
	 */
	protected function _updateUrl()
	{
		$update	=	$this->getUpdate();
		if ( $update == null ) return false;
		return ( isset ( $update->downloads->downloadurl->value ) ? $update->downloads->downloadurl->value : false );
	}
	
	
	/**
	 * Method for writing an update out
	 * @access		protected
	 * @version		@fileVers@
	 *
	 * @return		boolean
	 * @since		1.3.0
	 */
	protected function _updateWrite()
	{
		
	}
}
