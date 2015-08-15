<?php
/**
 * @package
 * @version
 */
/*
Plugin Name: Dunamis
Plugin URI: https://www.gohigheris.com
Description: This is the description
Author: Go Higher Information Services, Inc.
Version: @fileVers@
Author URI: https://www.gohigheris.com
*/

add_action( 'init', 'dunamis_init' );


function dunamis_init()
{
	$path	=	__DIR__ . DIRECTORY_SEPARATOR . 'dunamis' . DIRECTORY_SEPARATOR . 'dunamis.php';
	
	if ( file_exists( $path ) ) {
		include_once $path;
	}
	
	if (! function_exists( 'get_dunamis' ) ) {
		return;
	}
	
	$dunamis	=	get_dunamis();
	
	// Ensure we are enabled before proceeding
	if (! $dunamis->isenabled() ) {
		return;
	}
	
	// Lets attach hooks
	dunloader( 'hooks', true )->attachHooks( 'dunamis' );
	
	// We are enabled, so lets go ahead and load up
	//echo '<pre>'.print_r($dunamis,1);die();
	//list_hooked_functions();
	//die();
}