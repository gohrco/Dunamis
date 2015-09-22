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
 * Toggle Button Field
 * @desc		This is used to render and manage the toggle button field for a form in the Dunamis Framework
 * @package		Dunamis
 * @subpackage	Core
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
*/
class WordpressTogglebtnDunFields extends TogglebtnDunFields
{
	
	/**
	 * Stores the value used to identify the id in the options passed along
	 * @access		protected
	 * @var			string
	 * @since		1.5.0
	 */
	protected $_optid	= 'id';
	
	/**
	 * Stores the value used to identify the name in the options passed along
	 * @access		protected
	 * @var			string
	 * @since		1.5.0
	 */
	protected $_optname	= 'name';
	
	/**
	 * Stores the options passed along to the field
	 * @access		protected
	 * @var			array
	 * @since		1.5.0
	 */
	protected $options	= array();
	
	/**
	 * Stores the value assigned to the field
	 * @access		protected
	 * @var			array
	 * @since		1.5.0
	 */
	protected $value	= array();
	
	
	/**
	 * Adds the javascript to the document
	 * @access		private
	 * @version		@fileVers@
	 * 
	 * @since		1.5.0
	 */
	protected function _addJavascript()
	{
		static $data = false;
		
		$doc	= dunloader( 'document', true );
		
		if (! $data ) {
			$base	= get_baseurl( 'client' );
			$uri	= DunUri :: getInstance( $base, true );
			$uri->delVars();
			$doc->addScript( rtrim( $base, '/' ) . '/wp-content/plugins/dunamis/dunamis/core/assets/js/togglebtns.js' );
			$data	= true;
		}
		
		$id		= $this->getId();
		$value	= $this->get( 'value' );
		$value	= $value === null ? array('1') : $value;
		$doc->addScriptDeclaration( 'jQuery("document").ready( function () { togglebtns(\'' . $id . '\', \'' . $value[0] . '\' ); });' );
	}
}