<?php


/* ========================================================================= *\
 * GENERAL TRANSLATION STRINGS
\* ========================================================================= */

// -------------------------------------------------------------------------
// Alert Titles
// v1.5.0
$lang['alert.success']		= 'Success!';
$lang['alert.error']		= 'An Error Occurred!';
$lang['alert.info']			= 'Reminder:';
$lang['alert.block']		= 'Warning!';


// -------------------------------------------------------------------------
// Alert Messages
// v1.5.0
$lang['alert.settings.saved']					=	'Settings have been saved!';


// -------------------------------------------------------------------------
// Form Buttons
// v1.5.0
$lang['form.submit']				= 'Submit';
$lang['form.close']					= 'Close';
$lang['form.cancel']				= 'Cancel';
$lang['form.edit']					= 'Edit';
$lang['form.delete']				= 'Delete';
$lang['form.toggleyn.enabled']		= 'Enabled';
$lang['form.toggleyn.disabled']		= 'Disabled';
$lang['form.toggleyn.on']			= 'On';
$lang['form.toggleyn.off']			= 'Off';
$lang['form.button.addnew']			= 'Add New';


/* ========================================================================= *\
 * BACKEND TRANSLATION STRINGS - GENERAL
\* ========================================================================= */

// -------------------------------------------------------------------------
// Configuration Strings
// v1.5.0
$lang['menu.main']				=	'Dunamis';
$lang['menu.settings']			=	'Settings';

$lang['title.main']				=	'Dunamis :: Dashboard';
$lang['title.settings']			=	'Dunamis :: Settings';
$lang['addon.title']			= 'Dunamis Framework';
$lang['addon.author']			= '<div style="text-align: center; width: 100%; ">Go Higher<br/>Information Services, LLC</div>';
$lang['addon.description']		= 'This is the core framework used by the next generation of WHMCS modules!';


/* ========================================================================= *\
 * BACKEND TRANSLATION STRINGS - ADDON AREA
\* ========================================================================= */

// -------------------------------------------------------------------------
// Default Area
// v1.5.0
$lang['home.subtitle']			=	'<h2>Welcome!</h2>';
$lang['home.body']	= '
<p>Thank you for installing the Dunamis Framework for Wordpress!  The Dunamis Framework is a continuing project to create a rapid deployment platform for multiple applications using consistant methods and techniques.</p>
<h3>What does <em>Dunamis</em> mean?</h3>
<p>In Greek, the word dunamis means explosive; it is literally the origin of the word dynamite.  We chose dunamis as the name of this framework because we hope and expect deployments of new products and ideas for multiple platforms to literally explode onto the marketplace!</p>
<h3>Is <em>Dunamis</em> free?  Can I use it for my projects?</h3>
<p>Dunamis is being released as an open sourced project under the GPL2 license but is not currently documented or supported.  You are welcome to use and modify the files as you need.</p>
<h3>Does it DO anything in Wordpress?</h3>
<p>While it may appear that the Dunamis Framework is not doing anything, it is provided as an addon so that future updates and releases will be easy to track.  In addition, there are more core functionality that will be added in over time including the ability to check for and notify for module updates and provide an installation location for those modules utilizing the Dunamis Framework.</p>
';

// -------------------------------------------------------------------------
// Addon Titles
// v1.5.0
$lang['admin.title']						= 'Dunamis Framework <small>%s</small>';
$lang['admin.subtitle.default.default']		=	'Dashboard';
$lang['admin.subtitle.settings.default']	=	'Settings';
$lang['admin.subtitle.settings.save']		=	'Settings :: Save Settings';
$lang['admin.subtitle.updates.default']		=	'Updates';
$lang['admin.subtitle.installer.default']	=	'Installer';



// -------------------------------------------------------------------------
// Navigation Strings
// v1.5.0
$lang['admin.navbar.default']		=	'Home';
$lang['admin.navbar.settings']		=	'Settings';
$lang['admin.navbar.updates']		=	'Updates';
$lang['admin.navbar.installer']		=	'Installer';


// -------------------------------------------------------------------------
// Widget Strings - Updates
// v1.5.0
$lang['admin.widget.updates.header']		= 'Software Updates v%s';
$lang['admin.widget.updates.body.none']		=	'<p>You are running the latest version of Dunamis!</p>';
$lang['admin.widget.updates.body.error']	=	'<p>An error occurred checking for the latest updates:</p><pre>%s</pre>';
$lang['admin.widget.updates.body.exist']	=	'<p><strong>Dunamis version %s</strong> is available for download.  Please visit our web site at https://www.gohigheris.com to download the latest product.</p>';



// -------------------------------------------------------------------------
// Settings Strings
// v1.5.0
$lang['admin.settings.subnav.general']				=	'<i class="icon-off"> </i> <strong>General Settings</strong>';
$lang['admin.form.settings.label.debug']			=	'Debug';
$lang['admin.form.settings.description.debug']		=	'Use this setting to enable or disable debugging for the module.';

$lang['admin.form.settings.label.dlid']				=	'Download ID';
$lang['admin.form.settings.description.dlid']		=	'This is the Download ID available from our web site.  Simply retrieve it and enter it here for the update feature to work.';


//
//	Admin Configuration Translations
//			WHMCS > Addon Modules
//	------------------------------------------------------------------------



$lang['admin.title.home']		=	'Homepage';
$lang['admin.title.settings']	=	'Settings';
$lang['admin.title.updates']	=	'Updates';
$lang['admin.title.installer']	=	'Installer';

$lang['admin.subtitle.home.default']		=	'Homepage';
$lang['admin.subtitle.settings.default']	=	'Settings';
$lang['admin.subtitle.updates.default']		=	'Updates';
$lang['admin.subtitle.installer.default']	=	'Installer';




$lang['updates.subtitle']			=	'<h2>Coming Soon!</h2>';
$lang['updates.body']	= '
<p>This feature has not yet been implemented but is in the development stage.</p>
';

$lang['installer.subtitle']			=	'<h2>Coming Soon!</h2>';
$lang['installer.body']	= '
<p>This feature has not yet been implemented but is in the development stage.</p>
';


//	------------------------------------------------------------------------
//	Updates
//		as of 2.0.0
//	------------------------------------------------------------------------
$lang['updates.checking.title']		=	"Checking for Updates";
$lang['updates.checking.subtitle']	=	"Please wait...";

$lang['updates.none.title']		=	"Check Complete";
$lang['updates.none.subtitle']	=	"Your version %s is the latest release";

$lang['updates.exist.title']	=	"Updates Found!";
$lang['updates.exist.subtitle']	=	"Click to update";

$lang['updates.init.title']		=	"Downloading Update";
$lang['updates.init.subtitle']	=	"Downloading version %s...";

$lang['updates.download.title']		=	"Installing Update";
$lang['updates.download.subtitle']	=	"Installing version %s...";

$lang['updates.complete.title']		=	"Upgrade Complete!";
$lang['updates.complete.subtitle']	=	"Version %s installed";


?>