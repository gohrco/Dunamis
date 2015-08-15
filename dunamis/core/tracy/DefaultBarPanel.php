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
class DefaultBarPanel implements IBarPanel
{
	private $id;

	public $data;


	public function __construct($id)
	{
		$this->id = $id;
	}

	
	/**
	 * Method to add data to our object easily and consistantly
	 * @access		public
	 * @version		@fileVers@
	 * @param		string
	 * @param		string
	 * @param		string
	 * 
	 * @since		1.5.0
	 */
	public function addData( $file, $line, $message )
	{
		if (! \Tracy\Debugger :: isEnabled() ) return;
		
		$key	=	"{$file}|{$line}|{$message}";
		
		if (! isset( $this->data[$key] ) ) $count = 0;
		else $count = $this->data[$key];
		
		$count++;
		
		$this->data[$key]	=	$count;
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
