<?php
/**
 * Parser test file
 *
 * @package Widgetizer
 */

use Tester\Assert;
use Wpseed\Widgetizer\Elementor\Parser;

require __DIR__ . '/../../../../vendor/autoload.php';

Tester\Environment::setup();

$o = new Parser();

Assert::same( 'Hello John', $o->parse_dir( '../../widgets/elementor' ) );
