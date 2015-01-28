<?php
/**
 * @package         @packageName@
 * @subpackage		Blesta
 * @version         @fileVers@
 *
 * @author          @buildAuthor@
 * @link            @buildUrl@
 * @copyright       @copyRight@
 * @license         @buildLicense@
 */

// Do not include the script access check - blesta installer needs access to this file before dunamis does

/**
 * Used for sending output straight to screen wrapped in <pre> tags or a var dump of a string
 * @version		@fileVers@
 * @param		mixed		- $array: contains the data to output
 * @param		bool		- $die: to kill the application and die on the spot
 *
 * @since		1.0.4
 */
if (! function_exists( '_d' ) ) {
	function _d( $array, $die = false, $setbt = 0 )
	{
		$bt = debug_backtrace();
		$bt = $bt[$setbt];
		
		echo '<h5>' . $bt['file'] . ' @ line ' . $bt['line'] . '</h5>';

		if ( is_string( $array ) ) {
			echo '<pre>'; var_dump( $array ); echo '</pre>';
		}
		else {
			echo '<pre>' . print_r($array,1) . '</pre>';
		}

		if ( $die ) die();
		
	}
}


if (! function_exists( 'list_hooked_functions' ) ) {
	function list_hooked_functions($tag=false){
		global $wp_filter;
		if ($tag) {
			$hook[$tag]=$wp_filter[$tag];
			if (!is_array($hook[$tag])) {
				trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
				return;
			}
		}
		else {
			$hook=$wp_filter;
			ksort($hook);
		}
		echo '<pre>';
		foreach($hook as $tag => $priority){
			echo "<br /><h4><u><strong>$tag</strong></u></h4>";
			ksort($priority);
			foreach($priority as $priority => $function){
				echo $priority;
				foreach($function as $name => $properties) echo "$name<br />";
			}
		}
		echo '</pre>';
		return;
	}
}