<?php
/**
 * @projectName@
 *
 * @package    @packageName@
 * @copyright  @copyWrite@
 * @license    @buildLicense@
 * @version    @fileVers@ ( $Id$ )
 * @author     @buildAuthor@
 * @since      1.3.3
 *
 * @desc       This file is the Dunamis file for Dunamis component
 *
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Define the Dunamis version here
 */
if (! defined( 'DUN_MOD_DUNAMIS' ) )		define( 'DUN_MOD_DUNAMIS', "@fileVers@" );
if (! defined( 'DUN_MOD_COM_DUNAMIS' ) )	define( 'DUN_MOD_COM_DUNAMIS', "@fileVers@" );


class Com_dunamisDunModule extends DunModule
{
	public function initialise()
	{
		
	}
}