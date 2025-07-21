<?php

return function ($site) {
	$artifacts = $site->find('artifacts')->children();
	$artifactsUpdates = $artifacts->children();

	return $artifacts->merge($artifactsUpdates)->sortBy('date', 'desc');
};
