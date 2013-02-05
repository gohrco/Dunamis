<?php defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Document Class for Kayako
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		1.1.0
 */
class KayakoDunDocument extends DunDocument
{
	
	static public $iscompat	= false;
	
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
	 * Method to bring the output to compatibility with version desired
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $version: to bring to
	 * 
	 * @since		1.0.3
	 */
	public function makeCompatible( $version = '5.1' )
	{
// 		if ( self :: $iscompat ) return;
// 		else self :: $iscompat = $version;
		
// 		// We want to force the output to match the version we indicate
// 		switch ( $version ) :
// 		//
// 		// Bring in line w/ 5.1
// 		case '5.1' :
// 		default:
			
// 			if ( version_compare( DUN_ENV_VERSION, '5.1', 'ge' ) ) {
// 				return;
// 			}
// 			// 5.0 compatibility:  We have to load the jQuery 1.7.2 lib locally to bring compat w/ current version of W
// 			else if ( version_compare( DUN_ENV_VERSION, '5.0', 'ge' ) ) {
// 				$uri	= DunUri :: getInstance( get_baseurl(), true );
// 				$uri->delVars();
// 				$this->addScript( 'http' . ( $uri->isSSL() ? 's' : '' ) .'://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' );
// 			}
// 			// lol 4.....
// 			else {
// 				// Throw an error
// 			}
			
// 			break;	// End 5.1 compatibility
// 		endswitch;
	}
	
	
	/**
	 * Renders the data for the footer area
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		string
	 * @since		1.1.0
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
		
		if ( self :: $iscompat ) {
			$this->_unCompat( self :: $iscompat );
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
	 * @since		1.1.0
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
	
	
	
	/**
	 * Method to undo the compatibility
	 * @access		private
	 * @version		@fileVers@
	 * @param		string		- $version: contains the intended env we went to
	 * 
	 * @since		1.0.3
	 */
	private function _unCompat( $version = '5.1' )
	{
		
// 		// We want to force the output to match the version we indicate
// 		switch ( $version ) :
// 		//
// 		// Bring in line w/ 5.1
// 		case '5.1' :
// 		default:
// 			// Already at 5.1
// 			if ( version_compare( DUN_ENV_VERSION, '5.1.', 'ge' ) ) {
// 				return;
// 			}
// 			// Bring back from 5.0 to 5.1 compatibility
// 			else if ( version_compare( DUN_ENV_VERSION, '5.0', 'ge' ) ) {
// 				$this->addScriptDeclaration( 'jq172 = jQuery.noConflict();' );
// 			}
// 			else {
// 				// Throw error ?
// 			}
// 			break;
// 		endswitch;
		
// 		return;
	}
}