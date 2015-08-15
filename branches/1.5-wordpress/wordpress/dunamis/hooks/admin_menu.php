<?php

// // Top Level Menu Item
// add_menu_page( 'Dunamis Framework', t( 'dunamis.menu.main' ), 'manage_options', 'dunamis', array( dunmodule( 'dunamis.admin' ), 'admin_options' ) ); //, $function, $icon_url, $position );

// // Settings page
// add_options_page('Dunamis Settings', 'Dunamis', 'manage_options', 'dun_menu', array( dunmodule( 'dunamis.admin' ), 'admin_options' ) );
dunmodule( 'dunamis.admin' )->admin_menu();