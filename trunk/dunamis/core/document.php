<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * Dunamis Core Document File
 * This is the core Document handler of the Dunamis Framework
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

// define('DUNAMIS', true);
// include 'object.php';

/**
 * DunDocument Object
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.0.0
 */
class DunDocument extends DunObject
{
	
	/**
	 * Stores the script declarations to write to the site
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $_script	= array();
	
	/**
	 * Stores the scripts to write to the site
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $_scripts	= array();
	
	/**
	 * Stores styles to write to the site
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $_style	= array();
	
	/**
	 * Stores the stylesheets to write to the site
	 * @access		protected
	 * @var			array
	 * @since		1.0.0
	 */
	protected $_stylesheets	= array();
	
	
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
	 * Adds a script to the head (<script src=...>)
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $url: the source url
	 * @param		string		- $type: the type declaration
	 * @param		boolean		- $defer: adds the defer attribute
	 * @param		boolean		- $async: adds the async attribute
	 * 
	 * @return		self to permit chaining
	 * @since		1.0.0
	 */
	public function addScript( $url, $type = 'text/javascript', $defer = false, $async = false )
	{
		$this->_scripts[$url]['mime'] = $type;
		$this->_scripts[$url]['defer'] = $defer;
		$this->_scripts[$url]['async'] = $async;
		
		return $this;
	}
	
	
	/**
	 * Adds a script to the page
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $content: the script
	 * @param		string		- $type: the type of script
	 * 
	 * @return		self to permit chaining
	 * @since		1.0.0
	 */
	public function addScriptDeclaration($content, $type = 'text/javascript')
	{
		if (! isset( $this->_script[strtolower($type)] ) ) {
			$this->_script[strtolower($type)] = $content;
		}
		else {
			$this->_script[strtolower($type)] .= chr(13) . $content;
		}
		
		return $this;
	}
	
	
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
	 * @since		1.0.0
	 */
	public function addStyleSheet( $url, $type = 'text/css', $media = null, $attribs = array() )
	{
		$this->_stylesheets[$url]['mime'] = $type;
		$this->_stylesheets[$url]['media'] = $media;
		$this->_stylesheets[$url]['attribs'] = $attribs;
		
		return $this;
	}
	
	/**
	 * Adds a stylesheet declaration to the page
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $content: the style to write
	 * @param		string		- $type: the type of style we are writing
	 * 
	 * @return		self to permit chaining
	 * @since		1.0.0
	 */
	public function addStyleDeclaration( $content, $type = 'text/css' )
	{
		if (! isset( $this->_style[strtolower( $type )] ) ) {
			$this->_style[strtolower($type)] = $content;
		}
		else {
			$this->_style[strtolower( $type )] .= chr(13) . $content;
		}
		
		return $this;
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
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		1.0.0
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = null;
		
		if (! is_object( $instance ) ) {
			$instance	=	new self( $options );
		}
	
		return $instance;
	}
	
}