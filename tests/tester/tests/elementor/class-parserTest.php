<?php

use Tester\Assert;

require __DIR__ . '/../../../../vendor/autoload.php';

Tester\Environment::setup();

$o = new \Wpseed\Widgetizer\Elementor\Parser();

$expect_result = ['non-widgetizer', 'third-provider', 'widgetizer'];

Assert::same($expect_result, $o->parse_widgets(realpath('../../../widgets/elementor')));  # we expect the same
