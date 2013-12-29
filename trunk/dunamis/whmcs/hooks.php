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
 * Dunamis Hooks handler for WHMCS
 * @desc		This interacts with the WHMCS hook handler for the Dunamis Framework
 * @package		Dunamis
 * @subpackage	WHMCS
 * @author		@packageAuth@
 * @link		@packageLink@
 * @copyright	@packageCopy@
 * @license		@packageLice@
 */
class WhmcsDunHooks extends DunHooks
{
	/**
	 * Executes a hook point
	 * @access		public
	 * @version		@fileVers@
	 * @param		
	 * @param		string		- $extension: contains the calling extension to avoid conflicts
	 * 
	 * @since		1.0.0
	 */
	public function execute( $hookpoint, $extension, $type, $vars = array() )
	{
		static	$base = array();
		
		$paths		= array(
				'base' => DUN_PATH . DIRECTORY_SEPARATOR . strtolower( DUN_ENV ) . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR,
				'extension' => get_dunamis( $extension )->getModulePath( $extension, 'hooks' )
		);
		
		$contents	=	null;
		$contarray	=	array();
		
		foreach ( $paths as $is => $path ) {
			// Weed out the type we are executing (to avoid running twice)
			if ( $is != $type ) continue;
			
			// If we have already run the base hookpoint dont do it again
			if ( $is == 'base' && isset( $base[$hookpoint] ) ) continue;
			
			// Set so we don't do this again for base ones
			if ( $is == 'base' ) {
				$base[$hookpoint] = true;
			}
			
			// Obviously if the file doesn't exist that would be bad
			if (! file_exists( $path . $hookpoint . '.php' ) ) continue;
			
			// Output buffer to prevent output errors (duh)
			ob_start();
				include( $path . $hookpoint . '.php' );
			$content = ob_get_contents();
			ob_end_clean();
			
			// Nothing sent back via display, lets check response variable
			if ( empty( $content ) && isset( $response ) ) {
				$contarray += $response;
			}
			else {
				$contents .= $content;
			}
		}
		
		// Make a decision - contents or array... array!
		if (! empty( $contarray ) ) {
			return $contarray;
		}
		
		// Bye bye
		return $contents;
	}
	
	
	/**
	 * Sets the extension name in place
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $name: the name of the extension
	 *
	 * @since		1.0.0
	 * @param unknown_type $name
	 */
	public function setExtension( $name = null )
	{
		parent :: setExtension( $name );
	}
	
	
	/**
	 * Attach hooks to the system
	 * @access		public
	 * @version		@fileVers@
	 * @param		string		- $extension: the name of the module to attach to
	 * @param		integer		- $usepriority: if set we will use this priority when setting
	 * 
	 * @since		1.0.0
	 */
	public function attachHooks( $extension = null, $usepriority = 0 )
	{
		static 	$priority	= 500;
		static	$attached	= array();
		
		if ( isset( $attached[$extension] ) ) return;
		else $attached[$extension] = true;
		
		// Catch in case we are loading without initializing Dunamis
		if (! function_exists( 'add_hook' ) ) return;
		
		if ( $usepriority === 0 ) {
			$priority		= $priority + 10;
			$usepriority	= $priority;
		}
		
		$hooks		= WhmcsDunHooks :: getHookpoints();
		$ext		= $extension;
		$paths		= array(
						'base' => DUN_PATH . DIRECTORY_SEPARATOR . strtolower( DUN_ENV ) . DIRECTORY_SEPARATOR . 'hooks' . DIRECTORY_SEPARATOR,
						'extension' => get_dunamis( $extension )->getModulePath( $extension, 'hooks' )
					);
		
		foreach ( $hooks as $hook ) {
			foreach ( $paths as $type => $path ) {
				if ( file_exists( $path . $hook . '.php' ) ) {
					$functionname = "dunamis_{$extension}_{$type}_{$hook}";
					$newfunc = <<< CODE
					function {$functionname}( \$vars ) {
						return dunloader('hooks', true )->execute('{$hook}', '{$extension}', '{$type}', \$vars );
					}
CODE;
					eval( $newfunc );
					add_hook( $hook, $usepriority, $functionname );
				}
			}
		}
	}
	
	
	/**
	 * Private store of hook points in WHMCS
	 * @desc		Hook points as of WHMCS v5.1
	 * @access		private
	 * @static
	 * @version		@fileVers@
	 * @version		1.0.8		- Feb 2013: added 5.2 hook points based on beta changelog
	 * 
	 * @return		array
	 * @since		1.0.0
	 */
	static public function getHookpoints()
	{
		$data	= array(
					'ClientAdd', 'ClientAreaRegister', 'ClientEdit', 'ClientLogin', 'ClientLogout', 'ClientChangePassword', 'ClientDetailsValidation', 'ClientClose', 'ClientDelete', 'PreDeleteClient',
					'ContactAdd', 'ContactEdit', 'ContactDelete',
					'AfterModuleCreate', 'PreModuleCreate', 'AfterModuleSuspend', 'PreModuleSuspend', 'AfterModuleUnsuspend', 'PreModuleUnsuspend', 'AfterModuleTerminate', 'PreModuleTerminate', 'AfterModuleRenew', 'PreModuleRenew', 'AfterModuleChangePassword', 'AfterModuleChangePackage', 'AdminServiceEdit', 'CancellationRequest', 'AfterProductUpgrade', 'AfterConfigOptionsUpgrade',
					'AddonActivation', 'AddonAdd', 'AddonEdit', 'AddonActivated', 'AddonSuspended', 'AddonTerminated', 'AddonCancelled', 'AddonFraud', 'AddonDeleted',
					'PreDomainRegister', 'AfterRegistrarRegistration', 'AfterRegistrarRegistrationFailed', 'AfterRegistrarTransfer', 'AfterRegistrarTransferFailed', 'AfterRegistrarRenewal', 'AfterRegistrarRenewalFailed',
					'ShoppingCartValidateProductUpdate', 'ShoppingCartValidateCheckout', 'PreCalculateCartTotals', 'PreShoppingCartCheckout', 'AfterShoppingCartCheckout', 'ShoppingCartCheckoutCompletePage', 'AcceptOrder', 'CancelOrder', 'FraudOrder', 'PendingOrder', 'DeleteOrder',
					'InvoiceCreated', 'InvoiceCreationPreEmail', 'InvoiceCreationAdminArea', 'UpdateInvoiceTotal', 'AddInvoicePayment', 'InvoicePaid', 'InvoicePaidPreEmail', 'InvoiceUnpaid', 'InvoiceCancelled', 'InvoiceRefunded', 'ManualRefund', 'AddTransaction', 'LogTransaction', 'AddInvoiceLateFee', 'InvoicePaymentReminder', 'InvoiceChangeGateway',
					'TicketOpen', 'TicketAdminReply', 'TicketUserReply', 'TicketOpenAdmin', 'TicketAddNote', 'SubmitTicketAnswerSuggestions',
					'EmailPreSend', 'DailyCronJob', 'ClientAreaHomepage', 'ClientAreaPage', 'ClientAreaHeadOutput', 'ClientAreaHeaderOutput', 'ClientAreaFooterOutput', 'AdminAreaPage', 'AdminAreaHeadOutput', 'AdminAreaHeaderOutput', 'AdminAreaFooterOutput', 'AdminHomepage', 'AdminAreaClientSummaryPage', 'ViewOrderDetailsPage',
					'AdminLogin', 'AdminLogout', 'AnnouncementAdd', 'AnnouncementEdit', 'NetworkIssueAdd', 'NetworkIssueEdit', 'NetworkIssueClose', 'NetworkIssueReopen', 'NetworkIssueDelete', 'ProductEdit', 'ProductDelete', 'ServerAdd', 'ServerEdit', 'ServerDelete',
					'AffiliateActivation'
				);
		
		if ( version_compare( DUN_ENV_VERSION, '5.2', 'ge' ) ) {
			$data[]	=	'LicenseAddonReissue';
			$data[]	=	'AfterFraudCheck';
		}
		
		return $data;
	}
}