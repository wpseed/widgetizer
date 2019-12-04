<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::same( 'Hello_World', \Wpseed\Widgetizer\Helpers::dashes_to_class_name( 'hello-world' ) );
