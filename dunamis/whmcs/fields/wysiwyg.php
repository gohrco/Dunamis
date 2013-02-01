<?php

dunimport( 'fields.textarea' );

/**
 * WYSIWYG Field
 * @author		Steven
 * @version		@fileVers@
 * 
 * @since		1.0.5
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
			
			if ( version_compare( DUN_ENV_VERSION, '5.1', 'ge' ) ) {
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
		
		if ( version_compare( DUN_ENV_VERSION, '5.1', 'ge' ) ) {
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