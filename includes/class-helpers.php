<?php
/**
 * Helpers class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer;

/**
 * Class Helpers
 *
 * @package Wpseed\Widgetizer
 */
class Helpers {

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
}
