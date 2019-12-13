<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$o = new \Wpseed\Widgetizer\Elementor\Elementor_Builder(realpath( '../../test-widgets/widgets/elementor' ));

$expect_result = require '../../test-widgets/widgets/elementor/test-result.php';

Assert::same( $expect_result, $o->get_config() );
