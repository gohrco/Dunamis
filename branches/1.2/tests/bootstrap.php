<?php

defined( 'WHMCS' ) or define( 'WHMCS', true );

$ds	=	 DIRECTORY_SEPARATOR;

// Bamboo testing
if ( isset( $_ENV['bamboo'] ) && $_ENV['bamboo'] == 'true' ) {
	require_once '/home/jwhmcsco/public_html/hosting/includes/dunamis.php';
	require_once '/home/jwhmcsco/public_html/hosting/includes/dbfunctions.php';
	require_once '/home/jwhmcsco/public_html/hosting/configuration.php';
	$rootpath	=	'/home/jwhmcsco/public_html/hosting' . $ds;
}
else {
	require_once 'C:\xampp\www\mods\whmcs\includes\dunamis.php';
	require_once 'C:\xampp\www\mods\whmcs\includes\dbfunctions.php';
	require_once 'C:\xampp\www\mods\whmcs\configuration.php';
	$rootpath	=	'C:\xampp\www\mods\whmcs' . $ds;
}

/* ----------------------- */
/* Connect to our database */
/* ----------------------- */
global $whmcsmysql;
$whmcsmysql = mysql_connect( $db_name, $db_username, $db_password );
mysql_select_db( $db_name );
/* ----------------------- */
/* End Connect to database */
/* ----------------------- */

/* Register an autoloader */
spl_autoload_register( function ( $class )  {
	
	require_once $rootpath . 'includes' . $ds . 'dunamis' . $ds . 'core' . $ds . 'object.php';
	
	if ( strpos( $class, 'Dun' ) !== false ) {
		require_once $rootpath . 'includes' . $ds . 'dunamis' . $ds . 'core' . $ds . strtolower( str_replace( 'Dun', '', $class ) ) . '.php';
	}
	else if ( strpos( $class, 'Whmcs' ) !== false ) {
		$base	=	$rootpath . 'includes' . $ds . 'dunamis' . $ds . 'core' . $ds . strtolower( str_replace( 'Whmcs', '', $class ) ) . '.php';
		if ( file_exists( $base ) ) {
			require_once $base;
		}
		else {
			require_once $rootpath . 'includes' . $ds . 'dunamis' . $ds . 'whmcs' . $ds . strtolower( str_replace( 'Dun', '', $class ) ) . '.php';
		}
	}
	
});