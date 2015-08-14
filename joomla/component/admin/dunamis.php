<?php
/**
 * @projectName@
 * 
 * @package    @packageName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id: integrator.php 349 2015-06-09 03:14:05Z steven_gohigher $ )
 * @author     @buildAuthor@
 * @since      3.0.0
 * 
 * @desc       This is the main file for the backend of the Integrator
 *  
 */

/*-- Security Protocols --*/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'INT_VERS', '@fileVers@' );

// Ensure Dunamis is loaded
jimport( 'dunamis.dunamis' );

// Joomla 1.6+ Access check.
if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
	if (! JFactory::getUser()->authorise( 'core.manage', 'com_dunamis' ) ) {
		return JError::raiseWarning( 404, JText::_( 'JERROR_ALERTNOAUTHOR' ) );
	}
}

// -------------------------------------------------------
// Ensure we have Dunamis and it's loaded
if (! function_exists( 'get_dunamis' ) ) {
	$path	= dirname( dirname( dirname(__FILE__) ) ) . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'dunamis' . DIRECTORY_SEPARATOR . 'dunamis.php';
	if ( file_exists( $path ) ) require_once( $path );
}

if (! function_exists( 'get_dunamis' ) ) {
	// EPIC FAILURE HERE
	return;
}

get_dunamis( 'com_dunamis' );

$path	=	JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_dunamis' . DIRECTORY_SEPARATOR . 'dunamis.legacy.php';
if ( @file_exists( $path ) ) {
	require_once( $path );
}

if( $controller = JRequest::getWord( 'controller', 'default' ) ) {
	$path = JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controller . '.php';
	if ( @file_exists( $path ) ) {
		require_once $path;
	}
	else {
		$path = JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'default.php';
		require_once $path;
		$controller = 'default';
	}
}

// Create the controller class
$classname	= 'DunamisController' . ucfirst( $controller );
$controller	= new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();
