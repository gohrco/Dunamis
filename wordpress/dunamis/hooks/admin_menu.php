<?php

defined('DUNAMIS') OR exit('No direct script access allowed');

// Add our options page
add_options_page('Dunamis Settings', 'Dunamis', 'manage_options', 'dun_menu', array( dunmodule( 'dunamis.admin' ), 'admin_options' ) );
