<?php

return [
	'non-widgetizer' => [
		'no-config' => [],
	],
	'third-provider' => [],
	'widgetizer'     => [
		'hello-world' => [
			'title'   => 'Hello World!',
			'icon'    => 'eicon-posts-ticker',
			'content' => [
				'general'  => [
					'widget_title'   => [
						'type'    => 'text',
						'label'   => 'Widget Title',
						'default' => 'Default Title Content',
					],
					'widget_content' => [
						'type'    => 'textarea',
						'label'   => 'Widget Content',
						'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
					],
				],
				'advanced' => [
					'widget_code' => [
						'type'  => 'code',
						'label' => 'Widget Code',
					],
				],
			],
		],
		'minimal'     => [
			'title'   => 'Minimal',
			'content' => [
				'general' => null,
			],
		],
	],
];
