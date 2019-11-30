<?php
/**
 * Elementor widgets parser class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Elementor;

use Symfony\Component\Finder\Finder;

/**
 * Class Parser
 *
 * @package Wpseed\Widgetizer\Elementor
 */
class Parser {

	/**
	 * Parse widgets from directory.
	 *
	 * @param string $dir Directory for parsing widget configs.
	 * @return array $output Output config.
	 */
	public function parse_widgets( $dir = null ) {
		$output = [];
		$finder = new Finder();
		$folders = $finder->directories()->in($dir)->depth('== 0');
		foreach ( $folders as $folders_item ) {
			$output[] = $folders_item->getFileName();
		}
		return $output;
	}
}
