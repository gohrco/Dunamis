<?php defined('DUNAMIS') OR exit('No direct script access allowed');
/**
 * @projectName@ - Updates File
 *
 * @package         @packageName@
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */


/**
 * Dunamis Toolbar class handler
 * @version		@fileVers@
 *
 * @author		Steven
 * @since		3.1.00
 */
class Com_dunamisDunToolbar extends DunObject
{
	
	public function __construct( $options = array() )
	{
		
	}
	
	
	public function add( $controller, $task = null )
	{
		$canDo	=	$this->getActions();
		
		switch ( $controller ) {
			case 'default' :
				
				if ( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
					if ( $canDo->get( 'core.admin' ) ) {
						JToolBarHelper :: preferences(	'com_dunamis', '550', '875', 'JToolbar_Options'  );
					}
				}
				else {
					JToolBarHelper :: custom( 'config', 'config.png', '', JText::_( 'COM_DUNAMIS_ADMIN_BUTTON_PARAMETERS'), false, false );
				}
				
				break;
		}
	}
	
	
	/**
	 * Gets actions that are permitted for a user to perform
	 * @access		public
	 * @version		@fileVers@
	 *
	 * @return		JObject containing action sets
	 * @since		3.1.00
	 */
	public function getActions()
	{
		$user		= JFactory :: getUser();
		$result		= new JObject;
	
		$assetName	= "com_dunamis";
		$actions	= array(
				'core.admin',
				'core.manage',
				'core.create',
				'core.edit',
				'core.delete'
		);
	
		foreach ($actions as $action) {
			if ( version_compare( JVERSION, '1.6.0', 'ge' ) )
				$result->set($action,        $user->authorise($action, $assetName));
			else
				$result->set( $action, true );
				
		}
	
		return $result;
	}
	
	
	/**
	 * Singleton
	 * @access		public
	 * @static
	 * @version		@fileVers@
	 * @param		array		- $options: contains an array of arguments
	 *
	 * @return		object
	 * @since		3.1.00
	 */
	public static function getInstance( $options = array() )
	{
		static $instance = array();
	
		$serialize	=	serialize( $options );
	
		if (! isset( $instance[$serialize] ) ) {
			$instance[$serialize]	=	new self ( $options );
		}
	
		return $instance[$serialize];
	}
	
	
	/**
	 * Add the desired title to the backend 
	 * @access		public
	 * @version		@fileVers@
	 * @param		string
	 * @param		string
	 * @param		string
	 *
	 * @since		3.1.00
	 */
	public function title( $title, $icon = null, $subtitle = null )
	{
		if ( is_null( $subtitle ) ) {
			JToolBarHelper :: title( JText :: _( 'COM_DUNAMIS_TITLE_' . strtoupper( $title ) ), $icon );
		}
		else {
			JToolBarHelper :: title( sprintf( JText :: _( 'COM_DUNAMIS_TITLE_' . strtoupper( $title ) ), JText :: _( 'COM_DUNAMIS_SUBTITLE_' . strtoupper( $subtitle ) ) ), $icon );
		}
	}
}