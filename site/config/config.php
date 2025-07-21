<?php

return [
	'debug' => true,
	'thumbs' => [
		'presets' => [
			'project' => [
				'width' => 400,
				'format' => 'webp'
			]
		]
	],
	'routes' => [
		[
			'pattern' => 'artifact-details/(:any)',
			'method' => 'GET',
			'action' => function (string $artifactId) {
				if ($artifact = page('artifacts/' . $artifactId)) {
					return snippet('artifact-details', ['artifact' => $artifact], true);
				} else {
					return kirby()->response()->code(404);
				}
			}
		]
	]
];
