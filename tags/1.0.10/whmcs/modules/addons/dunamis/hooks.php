<?php
/**
 * Dunamis Hooks File
 * This initializes the Dunamis Framework on WHMCS regardless
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */


if (! function_exists( 'get_dunamis' ) ) {
	$path	= dirname( dirname( dirname( dirname(__FILE__) ) ) ) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'dunamis.php';
	if ( file_exists( $path ) ) require_once( $path );
}

if ( function_exists( 'get_dunamis' ) ) {
	get_dunamis( 'dunamis' );
}
