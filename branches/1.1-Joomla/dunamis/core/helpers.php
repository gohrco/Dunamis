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
	function _e( $array, $die = false, $setbt = 0 )
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


/**
 * Used for generating a random string
 * @version		@fileVers@
 * @param		string		- $type: what type of random string we want
 * @param		int			- $len: the length we want
 * 
 * @return		string
 * @since		1.1.0
 */
if ( ! function_exists('random_string')) {
	function random_string($type = 'alnum', $len = 8)
	{
		switch($type) {
			case 'basic'	: return mt_rand();
			break;
			case 'alnum'	:
			case 'numeric'	:
			case 'nozero'	:
			case 'alpha'	:
				
				switch ($type) {
					case 'alpha'	:	$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
					case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
					case 'numeric'	:	$pool = '0123456789';
					break;
					case 'nozero'	:	$pool = '123456789';
					break;
				}
				
				$str = '';
				for ($i=0; $i < $len; $i++) {
					$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
				}
				
				return $str;
				break;
			case 'unique'	:
			case 'md5'		:
				return md5(uniqid(mt_rand()));
				break;
		}
	}
}
		
/**
 * Used for converting a SimpleXMLElement to an associate array
 * @version		@fileVers@
 * @param		SimpleXMLElement	- $xml: the element to convert
 * @param		string				- $attributesKey: if known (for recursion) or @children
 * @param		string				- $childrenKey: if known (for recursion) or @attributes
 * @param		string				- $valueKey: if known (for recursion) or @values
 * 
 * @return		array
 * @since		1.0.5
 */
if (! function_exists( 'simpleXMLToArray' ) ) {
	function simpleXMLToArray( SimpleXMLElement $xml, $attributesKey = null, $childrenKey = null, $valueKey = null ) {
		if ( $childrenKey && ! is_string( $childrenKey ) ) {
			$childrenKey = '@children';
		}

		if ( $attributesKey && ! is_string( $attributesKey ) ) {
			$attributesKey = '@attributes';
		}

		if ( $valueKey && ! is_string( $valueKey ) ) {
			$valueKey = '@values';
		}

		$return	= array();
		$name	= $xml->getName();
		$_value	= trim((string)$xml);

		if ( $_value == '>' ) $_value = ''; // CHANGE 3.0.1 (0.1)

		if (! strlen( $_value ) ) {
			$_value = null;
		}

		if ( $_value !== null ) {
			if ( $valueKey ) {
				$return[$valueKey] = $_value;
			}
			else {
				$return = $_value;
			}
		}

		$children	= array();
		$first		= true;

		foreach ( $xml->children() as $elementName => $child )
		{
			$value	= simpleXMLToArray( $child, $attributesKey, $childrenKey, $valueKey );

			if ( isset( $children[$elementName] ) ) {
				if ( is_array( $children[$elementName] ) ) {
					if ( $first ) {
						$temp	= $children[$elementName];
						unset( $children[$elementName] );
						$children[$elementName][]	= $temp;
						$first	= false;
					}
					$children[$elementName][]	= $value;
				}
				else {
					$children[$elementName]	= array( $children[$elementName], $value );
				}
			}
			else {
				$children[$elementName]	= $value;
			}
		}

		if ( $children ) {
			if ( $childrenKey ) {
				$return[$childrenKey] = $children;
			}
			else {
				if (! empty( $return ) )  // CHANGE 3.0.1 (0.1)
					$return	= @array_merge( (array) $return, $children );
				else
					$return	= $children;
			}
		}

		$attributes	= array();
		foreach ( $xml->attributes() as $name => $value )
		{
			$attributes[$name]	= trim($value);
		}

		if ( $attributes ) {
			if ( $attributesKey ) {
				$return[$attributesKey] = $attributes;
			}
			else {
				if (! is_array( $return ) ) $return = array( 'value' => $return ); // CHANGE 3.0.1 (0.1)
				$return	= @array_merge( $return, $attributes );
			}
		}

		return $return;
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