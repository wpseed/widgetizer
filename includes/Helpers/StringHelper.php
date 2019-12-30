<?php
/**
 * Helpers class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Helpers;

/**
 * Class Helpers
 *
 * @package Wpseed\Widgetizer
 */
class StringHelper {

	/**
	 * Dashes to class name function
	 *
	 * @param string $str Original string with dashes.
	 *
	 * @return string String with class name format.
	 */
	public static function dashes_to_class_name( $str ) {
		return str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $str ) ) );
	}

	/**
	 * Check that given name only uses latin characters, digits, and dash
	 *
	 * @param string $string String to validate.
	 * @return boolean True if latin only, false otherwise.
	 */
	public static function is_widgetizer_slug( $string ) {
		if ( preg_match( '/^[a-z][-a-z0-9]*$/', $string ) ) {
			return true;
		}
		return false;
	}
}
