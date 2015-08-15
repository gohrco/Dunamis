<?php
/**
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

defined( 'DUNAMIS' ) OR exit('No direct script access allowed');

/**
 * Dunamis Document class for Wordpress
 * @desc		This handles document requests for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Wordpress
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WordpressDunDocument extends DunDocument
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.5.0
	 */
	public function __construct( $options = array() )
	{
		parent :: __construct( $options );
	}
	
	
	/**
	 * Adds a script to the head (<script src=...>)
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $url: the source url
	 * @param		string		- $type: the type declaration
	 * @param		boolean		- $defer: adds the defer attribute
	 * @param		boolean		- $async: adds the async attribute
	 *
	 * @return		self to permit chaining
	 * @since		1.5.0
	 */
// 	public function addScript( $url, $type = 'text/javascript', $defer = false, $async = false )
// 	{
// 		wp_enqueue_script( 'dunamis', $url, array(), false, false );
// 	}
	
	
	/**
	 * Adds a script to the page
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $content: the script
	 * @param		string		- $type: the type of script
	 *
	 * @return		self to permit chaining
	 * @since		1.5.0
	 */
// 	public function addScriptDeclaration($content, $type = 'text/javascript')
// 	{
		
// 	}
	
	
	/**
	 * Adds a linked stylesheet to the page
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $url: the source of the stylesheet
	 * @param		string		- $type: the encoding type
	 * @param		string		- $media: the media type applied to
	 * @param		array		- $attribs: any attributes to set
	 *
	 * @return		self to permit chaining
	 * @since		1.5.0
	 */
	public function addStyleSheet( $url, $type = 'text/css', $media = null, $attribs = array() )
	{
		return parent :: addStyleSheet( $url, $type, $media, $attribs );
// 		wp_enqueue_style( 'dunamis', $url );
// 		return $this;
	}
	
	
	/**
	 * Adds a stylesheet declaration to the page
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $content: the style to write
	 * @param		string		- $type: the type of style we are writing
	 *
	 * @return		self to permit chaining
	 * @since		1.5.0
	 */
	public function addStyleDeclaration( $content, $type = 'text/css' )
	{
		return parent :: addStyleDeclaration( $content, $type );
// 		wp_add_inline_style( 'dunamis', $content );
// 		return $this;
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
		foreach ( $this->_stylesheets as $strSrc => $strAttr) {
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
	
	
	/**
	 * Renders the head data
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.5.0
	 */
	public function renderScripts()
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
		
		echo $buffer;
	}
	
}