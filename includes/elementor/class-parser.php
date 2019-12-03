<?php
/**
 * Elementor widgets parser class file
 *
 * @package Widgetizer
 */

namespace Wpseed\Widgetizer\Elementor;

use Nette\Neon\Neon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Wpseed\Widgetizer\Validate;

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
	 * @return array $output Output summary config.
	 */
	public function parse_widgets( $dir = null ) {
		$output         = array();
		$fs             = new Filesystem();
		$neon           = new Neon();
		$folders_finder = new Finder();
		$folders        = $folders_finder->directories()->in( $dir )->depth( '== 0' )->sortByName();
		foreach ( $folders as $folders_item ) {
			$current_provider            = $folders_item->getFileName();
			$output[ $current_provider ] = false;
			if ( Validate::name( $current_provider ) ) {
				$subfolders_finder           = new Finder();
				$subfolders                  = $subfolders_finder->directories()->in( $dir . '/' . $current_provider )->depth( '== 0' )->sortByName();
				$output[ $current_provider ] = array();
				if ( iterator_count( $subfolders ) ) {
					foreach ( $subfolders as $subfolders_item ) {
						$current_widget                                 = $subfolders_item->getFileName();
						$output[ $current_provider ][ $current_widget ] = array();
						if ( Validate::name( $current_widget ) ) {
							$current_widget_config_path = $dir . '/' . $current_provider . '/' . $current_widget . '/' . $current_widget . '.neon';
							if ( $fs->exists( $current_widget_config_path ) ) {
								$current_widget_config                          = $neon::decode( \Nette\Utils\FileSystem::read( $current_widget_config_path ) );
								$output[ $current_provider ][ $current_widget ] = $current_widget_config;
							}
						}
					};
				}
			}
		}
		return $output;
	}
}
