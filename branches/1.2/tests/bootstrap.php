<?php

defined( 'WHMCS' ) or define( 'WHMCS', true );

// Bamboo testing
if ( isset( $_ENV['bamboo'] ) && $_ENV['bamboo'] == 'true' ) {
	require_once '/home/jwhmcsco/public_html/hosting/includes/dunamis.php';
}
else {
	require_once 'C:\xampp\www\mods\whmcs\includes\dunamis.php';
}

spl_autoload_register( function ( $class )  {
	
	require_once '/home/jwhmcsco/public_html/hosting/includes/dunamis/core/object.php';
	
	if ( strpos( $class, 'Dun' ) ) {
		require_once '/home/jwhmcsco/public_html/hosting/includes/dunamis/core/' . strtolower( str_replace( 'Dun', '', $class ) ) . '.php';
	}
	else if ( strpos( $class, 'Whmcs' ) ) {
		$base	=	'/home/jwhmcsco/public_html/hosting/includes/dunamis/core/' . strtolower( str_replace( 'Whmcs', '', $class ) ) . '.php';
		if ( file_exists( $base ) ) {
			require_once $base;
		}
		require_once '/home/jwhmcsco/public_html/hosting/includes/dunamis/whmcs/' . strtolower( str_replace( 'Whmcs', '', $class ) ) . '.php';
	}
	
});