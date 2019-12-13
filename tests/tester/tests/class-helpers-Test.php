<?php

use Tester\Assert;
use Wpseed\Widgetizer\Helpers;

require __DIR__ . '/../bootstrap.php';

Assert::same( 'Hello_World', Helpers::dashes_to_class_name( 'hello-world' ) );
