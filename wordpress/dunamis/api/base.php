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

/*-- Security Protocols --*/
defined('DUNAMISAPI') or die( 'Restricted access' );
/*-- Security Protocols --*/

/**
 * Base API Class
 * @version		@fileVers@
 *
 * @since		1.5.0
 * @author		Steven
 */
class DunamisDunApidispatch
{
	
	/**
	 * Method for returning an error
	 * @access		protected
	 * @version		@fileVers@
	 * @param		mixed		- $data: contains data to send back
	 * 
	 * @since		1.5.0
	 */
	protected function error( $data )
	{
		if (! is_array( $data ) ) $data = (array) $data;
		$this->_response( array( 'result' => 'error', 'error' => $data ) );
	}
	
	
	/**
	 * Method for executing on the API
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.5.0
	 */
	public function execute() { }
	
	
	/**
	 * Method for returning data successfully
	 * @access		protected
	 * @version		@fileVers@
	 * @param		mixed		- $data: the data to send back
	 * 
	 * @since		1.5.0
	 */
	protected function success( $data )
	{
		$this->_response( array( 'result' => 'success', 'data' => $data ) );
	}
	
	
	/**
	 * Method for sending a response
	 * @access		private
	 * @version		@fileVers@
	 * @version		2.6.0		- Added debug code
	 * @param		array		- $data: contains the data to render back to the user
	 * 
	 * @since		1.5.0
	 */
	private function _response( $data )
	{
		$data['debug']	=	dunloader( 'debug', true )->renderforApi();
		$string	= json_encode( $data );
		exit( $string );
	}
}