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
		// Initialize language object
// 		$lang	= & dunloader( 'language', true )->getLanguage();
		
		$args	= func_get_args();
		$string	= array_shift( $args );
		
		return dunloader( 'language', true )->translate( $string, $args );
	}
}