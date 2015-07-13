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

defined('DUNAMIS') OR exit('No direct script access allowed');

/**
 * Dunamis Error class for WHMCS
 * @desc		This is the error handler for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunError extends DunError
{
	
	/**
	 * Method to actually display the errors back
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		string			The error level we want to have returned
	 * 
	 * @return		string			Contains the errors in an HTML table
	 * @since		1.0.0
	 */
	static public function displayErrors( $level = 'ERROR' )
	{
		// See if we have error reporting enabled
		if (! get_errorsetting_whmcs( 'DebugErrors' ) ) return null;
		return null;
		$stack	= self :: $_stack;
		$check	= self :: checkLevels( $level );
		
		$errors	= '<div id="dunerrors" class="">';
		
		foreach ( $stack as $item ) {
			if (! isset( $item['code'] ) || ! isset( $item['msg'] ) || ! isset( $item['line'] ) || ! isset( $item['path'] ) ) continue;
			if (! in_array( $item['code'], $check ) ) continue;
			$type	= self :: translate( $item['code'] );
			$errors	.=	'<div style="clear: both; "></div>'
					.	'<div class="debugitem code' . $item['code'] . '">'
					.	'<h4>A PHP Error was Encountered<span>' . $type . '</span></h4>'
					.	'<span class="line"><strong>Message:</strong> ' . $item['msg'] . '</span><br/>'
					.	'<span class="line"><strong>Filename:</strong> ' . $item['path'] . '</span><br/>'
					.	'<span class="line"><strong>@ Line:</strong> ' . $item['line'] . '</span>'
					.	'</div>'
					.	'</div><div id="dunerrors" class="">';
		}
		$errors .= '</div>';
		
		return $errors;
	}
	
	
	/**
	 * Method to set the styling for error display in the document handler
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * 
	 * @since		1.0.0
	 */
	static public function setStyle()
	{
		$css	= <<<CSS
#dunerrors .debugitem {
	background-color: #F5F5F5;
	border: 1px dashed rgba(0, 0, 0, 0.1);
	border-radius: 4px 4px 4px 4px;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
	color: #888888;
	font-size: 11px;
	padding: 2px 10px;
}

#dunerrors .debugitem {
	color: #000000;
	margin: 5px;
}

#dunerrors h4 {
	border-bottom: 1px solid #000000;
	font-weight: bold;
	margin: 0;
	padding: 3px 0;
}

#dunerrors h4 span {
	float: right;
}

#dunerrors .code1 h4, #dunerrors .code2 h4, #dunerrors .code4 h4, #dunerrors .code16 h4, #dunerrors .code32 h4, #dunerrors .code64 h4, #dunerrors .code128 h4, #dunerrors .code256 h4, #dunerrors .code512 h4, #dunerrors .code2048 h4 {
	color: #FF0000;
	border-color: #FF0000;
}

#dunerrors .line {
	margin-left: 30px;
}
	
	
CSS;
		dunloader( 'document', true )->addStyleDeclaration( $css );
	}
	
	
	/**
	 * Method to provide translations for error codes
	 * @static
	 * @access		public
	 * @version		@fileVers@
	 * @param		integer			The error code to translate
	 *
	 * @return		string			Contains the translated code
	 * @since		1.0.0
	 */
	static public function translate( $code = 1 )
	{
		return DunError :: translate( $code );
	}
}
