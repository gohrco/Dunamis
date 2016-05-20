<?php
return;
defined( 'WHMCS' ) or define( 'WHMCS', true );
global $rootpath;
$ds	=	 DIRECTORY_SEPARATOR;

// Bamboo testing
if ( isset( $_ENV['bamboo'] ) && $_ENV['bamboo'] == 'true' ) {
	defined( 'BAMBOO' ) or define( 'BAMBOO', true );
	require_once '/home/jwhmcsco/public_html/hosting/includes/classes/class.init.php';
	require_once '/home/jwhmcsco/public_html/hosting/includes/dunamis.php';
	require_once '/home/jwhmcsco/public_html/hosting/includes/dbfunctions.php';
	require_once '/home/jwhmcsco/public_html/hosting/configuration.php';
	$rootpath	=	'/home/jwhmcsco/public_html/hosting' . $ds;
}
else {
	defined( 'BAMBOO' ) or define( 'BAMBOO', false );
// 	require_once 'C:\xampp\www\mods\whmcs\includes\classes\WHMCS\Init.php';
	require_once 'C:\xampp\www\mods\whmcs\includes\dunamis.php';
	require_once 'C:\xampp\www\mods\whmcs\includes\dbfunctions.php';
	require_once 'C:\xampp\www\mods\whmcs\configuration.php';
	$rootpath	=	'C:\xampp\www\mods\whmcs' . $ds;
}

/* ----------------------- */
/* Connect to our database */
/* ----------------------- */

error_reporting(0);
global $whmcsmysql;
$whmcsmysql = mysql_connect( $db_host, $db_username, $db_password );
mysql_select_db( $db_name );
error_reporting(E_ALL);


/* --------------- */
/* Initialize HTTP */
/* --------------- */
global $_SERVER;
if ( isset( $_ENV['bamboo'] ) && $_ENV['bamboo'] == 'true' ) {
	$_SERVER['HTTP_HOST']	=	'jwhmcs.com';
	$_SERVER['SCRIPT_NAME']	=	'/hosting/index.php';
}
else {
	$_SERVER['HTTP_HOST']	=	'localhost.com';
	$_SERVER['SCRIPT_NAME']	=	'/mods/whmcs/index.php';
}


/* ---------------- */
/* Initialize WHMCS */
/* ---------------- */

//global $whmcs;
//$whmcs	=	new WHMCS_Init();
//$whmcs	=	$whmcs->init();


/* ---------------------- */
/* Register an autoloader */
/* ---------------------- */

spl_autoload_register( function ( $class )  {
	
	global $rootpath;
	$ds	=	 DIRECTORY_SEPARATOR;
	
	//require_once $rootpath . 'includes' . $ds . 'dunamis' . $ds . 'core' . $ds . 'object.php';
	
	$base	=	$rootpath . 'includes' . $ds . 'dunamis' . $ds . 'core' . $ds . strtolower( str_replace( 'Dun', '', $class ) ) . '.php';
	if ( strpos( $class, 'Dun' ) !== false && strpos( $class, 'Dun' ) === 0 ) {
		if ( file_exists( $base ) ) {
			require_once $base;
		}
		else {
			return false;
		}
	}
	else if ( strpos( $class, 'Whmcs' ) !== false ) {
		$base	=	$rootpath . 'includes' . $ds . 'dunamis' . $ds . 'core' . $ds . strtolower( str_replace( 'Whmcs', '', $class ) ) . '.php';
		if ( file_exists( $base ) ) {
			require_once $base;
		}
		else {
			$base	=	$rootpath . 'includes' . $ds . 'dunamis' . $ds . 'whmcs' . $ds . strtolower( str_replace( 'Dun', '', $class ) ) . '.php';
			if ( file_exists( $base ) ) {
				require_once $rootpath . 'includes' . $ds . 'dunamis' . $ds . 'whmcs' . $ds . strtolower( str_replace( 'Dun', '', $class ) ) . '.php';
			}
			else {
				return false;
			}
		}
	}
	
});