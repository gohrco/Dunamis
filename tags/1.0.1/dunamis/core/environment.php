<?php defined('DUNAMIS') OR exit('No direct script access allowed');

class DunEnvironment extends DunObject
{
	public function defines()
	{
		// DUN_PATH:  /dunamis
		if (! defined( 'DUN_PATH' ) ) {
			define( 'DUN_PATH', dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR );
		}
		
		// DUN_CORE:  /dunamis/core
		if (! defined( 'DUN_CORE' ) ) {
			define( 'DUN_CORE', DUN_PATH . 'core' . DIRECTORY_SEPARATOR );
		}
	}
}