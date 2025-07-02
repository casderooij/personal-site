<?php

use SitePlugin\PosterGenerator;

return [
	'thumbs' => [
		'presets' => [
			'project' => [
				'width' => 400,
				'format' => 'webp'
			]
		]
	],
	'hooks' => [
		'file.create:after' => function ($file) {
			// Check if the uploaded file is a video
			if ($file->type() === 'video') {
				// Generate poster using the new class
				PosterGenerator::generatePoster($file, $file->parent());
			}
		},
		'file.delete:after' => function ($file) {
			// Delete poster using the new class
			PosterGenerator::deletePoster($file);
		}
	]
];
