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

// Ensure the dropdown fields are loaded
dunimport( 'fields.dropdown' );

/**
 * WYSIWYG Field
 * @desc		This is used to render and enable a WYSIWYG field for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class WhmcsWysiwygDunFields extends TextareaDunFields
{
	
	/**
	 * Indicates if the WYSIWYG javascript should be loaded
	 * @access		public
	 * @var			boolean
	 * @since		1.0.6
	 */
	public $enabled = true;
	
	
	/**
	 * Constructor method
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $settings: any settings to assign at initialization
	 * 
	 * @since		1.0.5
	 */
	public function __construct(  $settings = array() )
	{
		parent :: __construct( $settings );
	}
	
	
	/**
	 * Method to render the field to the browser
	 * @access		public
	 * @version		@fileVers@
	 * @param		array		- $options: any options to pass along
	 * 
	 * @return		html formatted string
	 * @since		1.0.6
	 * @see			TextareaDunFields :: field()
	 */
	public function field( $options = array() )
	{
		if ( $this->enabled ) { 
			$this->_loadJavascript();
		}
		
		return parent :: field( $options );
	}
	
	
	/**
	 * Method to enable or disable WYSIWYG editor
	 * @access		public
	 * @version		@fileVers@
	 * @param		boolean		- $value: value to set
	 * 
	 * @since		1.0.6
	 */
	public function setEnable( $value = true )
	{
		$this->enabled = (bool) $value;
	}
	
	
	/**
	 * Common manner of loading the javascript
	 * @desc		In WHMCS 5.0 they use tiny_mce, but 5.1 are using nicEditor
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.0.5
	 */
	private function _loadJavascript()
	{
		static $run = false;
		
		$doc = dunloader( 'document', true );
		
		if (! $run ) {
			$base	= get_baseurl( 'client' );
			$baseuri	= DunUri :: getInstance( $base, true );
			$baseuri->delVars();
			
			if ( version_compare( DUN_ENV_VERSION, '5.2', 'ge' ) ) {
				$doc->addStyleDeclaration( '#intouch .mceEditor table td { padding: 0; }' );
				
				$base	= get_baseurl( 'client' );
				$baseuri	= DunUri :: getInstance( $base, true );
				$baseuri->delVars();
				$baseuri->setPath( rtrim( $baseuri->getPath(), '/' ) . '/includes/jscript/tiny_mce/jquery.tinymce.js' );
			}
			else if ( version_compare( DUN_ENV_VERSION, '5.1', 'ge' ) ) {
				$baseuri->setPath( rtrim( $baseuri->getPath(), '/' ) . '/includes/jscript/editor.js' );
				
				$js	= "jQuery('document').ready(function() { var nicEd = new nicEditor({fullPanel: true}); });";
				$js	= "var nicEd = new nicEditor({fullPanel: true});";
				$doc->addScriptDeclaration($js);
			}
			else {
				// Correct jacked up styles
				$doc->addStyleDeclaration( '#intouch .mceEditor table td { padding: 0; }' );
				
				$base	= get_baseurl( 'admin' );
				$baseuri	= DunUri :: getInstance( $base, true );
				$baseuri->delVars();
				$baseuri->setPath( rtrim( $baseuri->getPath(), '/' ) . '/editor/tiny_mce.js' );
			}
			$doc->addScript( $baseuri->toString() );
			$run = true;
		}
		
		$id	= $this->getId();
		
		if ( version_compare( DUN_ENV_VERSION, '5.2', 'ge' ) ) {
			$js	=	<<< JS
jQuery().ready(function() {
	jQuery('#{$id}').tinymce({
		// Location of TinyMCE script
		script_url : "{$base}/includes/jscript/tiny_mce/tiny_mce.js",

		// General options
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,advlist",

		// Theme options
		theme_advanced_buttons1 : "fontselect,fontsizeselect,forecolor,backcolor,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		convert_urls : false,
		relative_urls : false,
		forced_root_block : false
	});
});
JS;
			
		}
		else if ( version_compare( DUN_ENV_VERSION, '5.1', 'ge' ) ) {
			$js	= <<< JS
jQuery('document').ready( function() {
	nicEd.panelInstance('{$id}');
});
JS;
		}
		else {
			$js	= <<< JS
tinyMCE.init({
	mode : "exact",
	elements : "{$id}",
	theme : "advanced",
	entity_encoding: "raw",
	convert_urls : false,
	relative_urls : false,
	plugins : "style,table,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,visualchars,xhtmlxtras",
	theme_advanced_buttons1 : "cut,copy,paste,pastetext,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|,search,replace",
	theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,|,forecolor,backcolor,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,cleanup,code,help",
	theme_advanced_buttons3 : "", // tablecontrols
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true
});
JS;
		}
		$doc->addScriptDeclaration( $js );
	}
}