<?php
/**
 * Validate class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer;

/**
 * Validate class
 *
 * @since  1.0.0
 */
final class Validate {
	/**
	 * Check that given name only uses latin characters, digits, and dash
	 *
	 * @param string $string String to validate.
	 * @return boolean True if latin only, false otherwise.
	 */
	public static function name( $string ) {
		if ( preg_match( '/^[\w\d\s-]*$/', $string ) ) {
			return true;
		}
		return false;
	}
}
