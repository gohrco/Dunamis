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
 * Ping API Class
 * @version		@fileVers@
 *
 * @since		1.5.0
 * @author		Steven
 */
class PingDunamisDunApidispatch extends DunamisDunApidispatch
{
	
	/**
	 * Method for executing on the API
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.5.0
	 * @see			DunamisDunApidispatch :: execute()
	 */
	public function execute()
	{
		// Lets test for curl_exec to ensure we can curl back
		if (! function_exists( 'curl_exec' ) ) {
			$this->error( 'The Wordpress installation does not seem to have curl installed!  Please ensure curl is installed and enabled in PHP and try again.' );
		}
		
		$this->success( 'pong' );
	}
}