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
 * Dunamis Document class for Joomla
 * @desc		This handles document requests for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Joomla
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class JoomlaDunDocument extends DunDocument
{
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @since		1.1.0
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
	 * @since		1.1.0
	 */
	public function addScript( $url, $type = 'text/javascript', $defer = false, $async = false )
	{
		$doc	=	$document = JFactory::getDocument();
		$doc->addScript( $url, $type, $defer, $async );
		
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
	 * @since		1.1.0
	 */
	public function addScriptDeclaration($content, $type = 'text/javascript')
	{
		$doc	=	$document = JFactory::getDocument();
		$doc->addScriptDeclaration( $content, $type );
		
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
	 * @since		1.1.0
	 */
	public function addStyleSheet( $url, $type = 'text/css', $media = null, $attribs = array() )
	{
		$doc	=	$document = JFactory::getDocument();
		$doc->addStyleSheet( $url, $type, $media, $attribs );
		
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
	 * @since		1.1.0
	 */
	public function addStyleDeclaration( $content, $type = 'text/css' )
	{
		$doc	=	$document = JFactory::getDocument();
		$doc->addStyleDeclaration( $content, $type );
		
		return $this;
	}
	
	
	/**
	 * Method for getting the base set in the document handler
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.4.0
	 */
	public function getBase()
	{
		$document	=	JFactory::getDocument();
		return $document->getBase();
	}
	
	
	/**
	 * Method for setting the base in the document handler
	 * @access		public
	 * @version		@fileVers@
	 * @param		string
	 * 
	 * @return		boolean
	 * @since		1.4.0
	 */
	public function setBase( $base )
	{
		$document	=	JFactory::getDocument();
		$document->setBase( $base );
		return true;
	}
}