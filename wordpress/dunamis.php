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
	
	if ( function_exists( 'get_dunamis' ) ) {
		$dunamis	=	get_dunamis();
	}
	
	//list_hooked_functions();
	
}