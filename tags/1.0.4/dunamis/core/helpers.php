<?php


/**
 * Function for converting an array over to a string
 * @version		@fileVers@
 * @since		1.0.0
 */
if (! function_exists( 'array_to_string' ) )
{
	function array_to_string( $array = null, $inner_glue = '=', $outer_glue = ' ', $keepOuterKey = false )
	{
		$output = array();

		if ( is_array( $array ) ) {
			foreach ( $array as $key => $item ) {
				if ( is_array( $item ) ) {
					if ( $keepOuterKey ) {
						$output[] = $key;
					}
					$output[] = array_to_string( $item, $inner_glue, $outer_glue, $keepOuterKey );
				}
				else {
					$output[] = $key . $inner_glue . '"' . $item . '"';
				}
			}
		}

		return implode($outer_glue, $output);
	}
}


/**
 * Used for sending output straight to screen wrapped in <pre> tags or a var dump of a string
 * @version		@fileVers@
 * @param		mixed		- $array: contains the data to output
 * @param		bool		- $die: to kill the application and die on the spot
 *
 * @since		1.0.4
 */
if (! function_exists( '_e' ) ) {
	function _e( $array, $die = false )
	{
		$bt = debug_backtrace();
		$bt = $bt[0];

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


/**
 * Function for translating a string given some unknown number of arguments
 * @version		@fileVers@
 * 
 * @return		string
 * @since		1.0.0
 */
if (! function_exists( 't' ) )
{
	function t()
	{
		$args	= func_get_args();
		$string	= array_shift( $args );
		return dunloader( 'language', true )->translate( $string, $args );
	}
}