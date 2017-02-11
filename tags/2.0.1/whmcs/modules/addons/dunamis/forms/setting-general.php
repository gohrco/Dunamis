<?php


$form	= array(
 		'debug'		=> array(
 				'order'			=> 20,
 				'type'			=> 'toggleyn',
 				'value'			=> true,
 				'validation'	=> '',
 				'labelon'		=> 'dunamis.form.toggleyn.enabled',
 				'labeloff'		=> 'dunamis.form.toggleyn.disabled',
 				'label'			=> 'dunamis.admin.form.settings.label.debug',
 				'description'	=> 'dunamis.admin.form.settings.description.debug',
 		),
		'log'		=> array(
				'order'			=> 25,
				'type'			=> 'toggleyn',
				'value'			=> false,
				'validation'	=> '',
				'labelon'		=> 'dunamis.form.toggleyn.enabled',
				'labeloff'		=> 'dunamis.form.toggleyn.disabled',
				'label'			=> 'dunamis.admin.form.settings.label.log',
				'description'	=> 'dunamis.admin.form.settings.description.log',
		),
		'dlid'	=> array(
				'order'			=>	30,
				'type'			=>	'text',
				'value'			=>	null,
				'validation'	=>	'',
				'label'			=>	'dunamis.admin.form.settings.label.dlid',
				'description'	=>	'dunamis.admin.form.settings.description.dlid',
		),
	);