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
final class Validator {
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
