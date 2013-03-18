<?php
/**
 * @projectName@
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.0.0
 *
 * @desc       This file is the api file loaded by WHMCS when requested via the WHMCS API
 *
 */

/*-- Security Protocols --*/
if (! defined( "WHMCS" ) ) die( "This file cannot be accessed directly" );
if (! defined( "APIAREA" ) ) define( "APIAREA", true );
/*-- Security Protocols --*/

/*-- Dunamis Inclusion --*/
if (! function_exists( 'get_dunamis' ) ) {
	$path	=	dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'dunamis.php';
	if ( file_exists( $path ) ) require_once( $path );
}
/*-- Dunamis Inclusion --*/

/*-- Dunamis Inclusion --*/
if ( function_exists( 'get_dunamis' ) ) {
	get_dunamis( 'dunamis' );
}
else {
	exit;
}
/*-- Dunamis Inclusion --*/

/*-- Determine the module to call up --*/
$input		=	dunloader( 'input', true );
$module		=	$input->getVar( 'module', false );
if (! $module ) exit;
/*-- Determine the module to call up --*/

if ( strpos( $module, '.' ) === false ) {
	$module .= '.' . $input->getVar( 'method', 'api' );
}

echo dunmodule( $module )->execute();
