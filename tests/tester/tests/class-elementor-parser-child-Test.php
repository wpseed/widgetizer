<?php

use Tester\Assert;
use Wpseed\Widgetizer\Elementor\Elementor_Builder;

require __DIR__ . '/../bootstrap.php';

$o = new Elementor_Builder( [ '../../test-widgets/widgets/elementor', '../../test-widgets/widgets-child/elementor' ] );

$expect_result = require '../../test-widgets/test-result-child.php';

Assert::same( $expect_result, $o->get_config() );
