<?php

// This form is used for phpunit testing


$form	= array(
		'name'	=> array(
				'order'	=> 10,
				'type' => 'text',
				'value' => null,
				'label' => 'dunamis.admin.form.group.label.name',
				'description' => 'dunamis.admin.form.group.desc.name',
		),
		'template' => array(
				'order' => 25,
				'type' => 'dropdown',
				'value' => null,
				'allownogroup' => true,
				'translateoptions' => false,
				'label' => 'dunamis.admin.form.group.label.template',
				'description' => 'dunamis.admin.form.group.desc.template',
		),
		// Begin button breakout
		'params' => array(
				'order'			=> 20,
				'type'			=> 'togglebtn',
				'value'			=> array( '1' ),
				'validation'	=> '',
				'options'		=> array(
						array( 'id' => '1', 'name' => 'dunamis.admin.form.group.params.optn.emails' ),
						array( 'id' => '2', 'name' => 'dunamis.admin.form.group.params.optn.invoices' ),
						array( 'id' => '3', 'name' => 'dunamis.admin.form.group.params.optn.quotes' )
				),
				'label'			=> 'dunamis.admin.form.group.params.label',
		),
		'emailcss' => array(
				'order'			=> 110,
				'type'			=> 'textarea',
				'value'			=> null,
				'label'			=> 'dunamis.admin.form.group.label.emailcss',
				'description'	=> 'dunamis.admin.form.group.desc.emailcss',
				'style'			=> 'width:95%;',
				'rows'			=> '2',
		),
		'gid' => array(
				'order' => 10000,
				'type' => 'hidden',
				'value' => 0,
		),
);