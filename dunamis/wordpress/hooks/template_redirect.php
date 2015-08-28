<?php


if ( empty( $GLOBALS['wp']->query_vars['dun_module'] ) ) {
	return;
}

$vars	=	(object) $GLOBALS['wp']->query_vars;

// We must have the module... duh
if (! isset( $vars->dun_module ) ) {
	$errors[]	=	'Missing the `dun_module` variable - unable to proceed';
	$this->set( 'errors', $errors );
	return;
}

// We are definitely an API request for the Dunamis Library at this point...
define( 'DUNAMISAPI', true );

$module	=	$vars->dun_module;
unset( $vars->dun_module );
$handler	=	dunloader( 'apiresponse', $module, (array) $vars );

if (! is_object( $handler ) ) {
	echo json_encode( array( 'result' => 'error', 'message' => 'Unable to load API Response handler - no object returned', 'debug' => dunloader( 'debug', true )->renderforApi() ) );
	exit();
}


if (! $handler->get( 'enabled' ) ) {
	$errors	=	(array) $handler->get( 'errors' );
	if (! empty( $errors ) ) {
		foreach ( $errors as $error ) {
			dunloader( 'debug', true )->error( $error );
		}
	}
	
	echo json_encode( array( 'result' => 'error', 'message' => 'There was a problem initializing the API Handler', 'errors' => $errors, 'debug' => dunloader( 'debug', true )->renderforApi() ) );
	exit();
}

$handler->respond();

?>