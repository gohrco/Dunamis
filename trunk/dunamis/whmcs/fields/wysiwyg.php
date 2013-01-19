<?php

dunimport( 'fields.textarea' );

class WhmcsWysiwygDunFields extends TextareaDunFields
{
	
	public function __construct(  $settings = array() )
	{
		parent :: __construct( $settings );
		$this->_loadJavascript();
	}
	
	
	private function _loadJavascript()
	{
		static $run = false;
		
		$doc = dunloader( 'document', true );
		
		if (! $run ) {
			$base	= get_baseurl( 'client' );
			$baseuri	= DunUri :: getInstance( $base, true );
			$baseuri->delVars();
			$baseuri->setPath( rtrim( $baseuri->getPath(), '/' ) . '/includes/jscript/editor.js' );
			$doc->addScript( $baseuri->toString() );
			$run = true;
		}
		
		$id	= $this->getId();
		$js	= <<< JS
jQuery('document').ready( function() {
	var ne = new nicEditor({fullPanel: true}).panelInstance( '{$id}' );
});
JS;
		$doc->addScriptDeclaration( $js );
	}
}