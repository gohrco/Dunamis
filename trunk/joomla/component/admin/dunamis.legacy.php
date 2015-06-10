<?php
/**
 * @projectName@
 * Joomla! - Legacy Handler
 *
 * @package    @projectName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      3.1.00
 *
 * @desc       This file permits Dunamis to operate across Joomla! versions
 *
 */


if ( version_compare( JVERSION, '3.0', 'ge' ) )
{
	if (! class_exists( 'DunamisControllerExt' ) ) {
		class DunamisControllerExt extends JControllerLegacy {}
	}
	if (! class_exists( 'DunamisControllerForm' ) ) {
		class DunamisControllerForm extends JControllerForm {}
	}
	if (! class_exists( 'DunamisModelExt' ) ) {
		class DunamisModelExt extends JModelLegacy {}
	}
	if (! class_exists( 'DunamisViewExt' ) ) {
		class DunamisViewExt extends JViewLegacy {}
	}
}
else if ( version_compare( JVERSION, '1.6', 'ge' ) )
{
	jimport('joomla.application.component.controller');
	jimport('joomla.application.component.controllerform');
	jimport('joomla.application.component.model');

	// Good ol' Joomla changing things up mid-stream
	if ( version_compare( JVERSION, '2.5.5', 'ge' ) ) {
		jimport( 'cms.view.legacy' );
		if (! class_exists( 'DunamisViewExt' ) ) {
			class DunamisViewExt extends JViewLegacy {}
		}
	} else {
		jimport( 'joomla.application.component.view' );
		if (! class_exists( 'DunamisViewExt' ) ) {
			class DunamisViewExt extends JView {}
		}
	}

	if (! class_exists( 'DunamisControllerExt' ) ) {
		class DunamisControllerExt extends JController {}
	}
	if (! class_exists( 'DunamisControllerForm' ) ) {
		class DunamisControllerForm extends JControllerForm {}
	}
	if (! class_exists( 'DunamisModelExt' ) ) {
		class DunamisModelExt extends JModel {}
	}
}
else
{
	jimport('joomla.application.component.controller');
	jimport('joomla.application.component.model');
	jimport( 'joomla.application.component.view' );

	if (! class_exists( 'DunamisControllerExt' ) ) {
		class DunamisControllerExt extends JController {}
	}
	if (! class_exists( 'DunamisControllerForm' ) ) {
		class DunamisControllerForm extends JController {}
	}
	if (! class_exists( 'DunamisModelExt' ) ) {
		class DunamisModelExt extends JModel {}
	}
	if (! class_exists( 'DunamisViewExt' ) ) {
		class DunamisViewExt extends JView {}
	}
}