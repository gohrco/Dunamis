<?php

/**
 * This file is part of the Tracy (http://tracy.nette.org)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

namespace Tracy;

use Tracy;


/**
 * IDebugPanel implementation helper.
 *
 * @author     David Grudl
 * @internal
 */
class ApiBarPanel implements IBarPanel
{
	private $id = 'api';

	public $data;


	public function __construct()
	{
		
	}

	
	/**
	 * Method to add data over to our debugger bar
	 * @access		public
	 * @version		@fileVers@
	 * @param		array
	 *
	 * @author		Steven Mueller
	 * @since		1.4.0
	 */
	public function addData( $data = array() )
	{
		if (! \Tracy\Debugger :: isEnabled() ) return;
	
		// Process incoming data
		extract( $data );
	
		// Lets get our debug info first
		$string	=	json_decode( preg_replace( "#^[^{]*#im", "", $result ), false );
		$debug	=	(! isset( $string->debug ) ? array() :  json_decode( base64_decode( $string->debug ), false ) );
	
		// Add to our stack
		$this->data[]	=	array( 'call' => $call, 'method' => $method, 'post' => $post, 'optns' => $optns, 'result' => $result, 'curlinfo' => $curlinfo, 'debug' => $debug );
	
	}
	
	
	/**
	 * Renders HTML code for custom tab.
	 * @return string
	 */
	public function getTab()
	{
		ob_start();
		require __DIR__ . "/templates/bar.{$this->id}.tab.phtml";
		return ob_get_clean();
	}


	/**
	 * Renders HTML code for custom panel.
	 * @return string
	 */
	public function getPanel()
	{
		ob_start();
		if (is_file(__DIR__ . "/templates/bar.{$this->id}.panel.phtml")) {
			require __DIR__ . "/templates/bar.{$this->id}.panel.phtml";
		}
		return ob_get_clean();
	}

}
