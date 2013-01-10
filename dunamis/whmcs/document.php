<?php defined('DUNAMIS') OR exit('No direct script access allowed');


class WhmcsDunDocument extends DunDocument
{
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.0.0
	 */
	public function __construct( $options = array() )
	{
		parent :: __construct( $options );
	}
	
	
	/**
	 * Renders the head data
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.0.0
	 */
	public function renderFootData()
	{
		$lnEnd	= "\12";
		$tab	= "\11";
		$buffer	= null;
	
		// Generate script file links
		foreach ( $this->_scripts as $strSrc => $strAttr ) {
			$buffer .= $tab . '<script src="' . $strSrc . '"';
	
			if (! is_null( $strAttr['mime'] ) ) {
				$buffer .= ' type="' . $strAttr['mime'] . '"';
			}
	
			if ( $strAttr['defer'] ) {
				$buffer .= ' defer="defer"';
			}
	
			if ( $strAttr['async'] ) {
				$buffer .= ' async="async"';
			}
	
			$buffer .= '></script>' . $lnEnd;
		}
	
		// Generate script declarations
		foreach ($this->_script as $type => $content) {
			$buffer .= $tab . '<script type="' . $type . '">' . $lnEnd;
			$buffer .= $content . $lnEnd;
			$buffer .= $tab . '</script>' . $lnEnd;
		}
	
		return $buffer;
	}
	
	
	/**
	 * Renders the head data
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @return		string
	 * @since		1.0.0
	 */
	public function renderHeadData()
	{
		$lnEnd	= "\12";
		$tab	= "\11";
		$buffer	= null;
		
		// Generate stylesheet links
		foreach ( $this->_styleSheets as $strSrc => $strAttr) {
			$buffer .= $tab . '<link rel="stylesheet" href="' . $strSrc . '" type="' . $strAttr['mime'] . '"';
			
			if (! is_null( $strAttr['media'] ) ) {
				$buffer .= ' media="' . $strAttr['media'] . '" ';
			}
			
			if ( $temp = array_to_string( $strAttr['attribs'] ) ) {
				$buffer .= ' ' . $temp;
			}
			
			$buffer .= " />" . $lnEnd;
		}
		
		// Generate stylesheet declarations
		foreach ( $this->_style as $type => $content ) {
			$buffer .= $tab . '<style type="' . $type . '">' . $lnEnd;
			$buffer .= $content . $lnEnd;
			$buffer .= $tab . '</style>' . $lnEnd;
		}
		
		return $buffer;
	}
	
	
	
}