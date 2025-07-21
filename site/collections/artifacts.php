<?php

return function ($site) {
	return $site
		->find('artifacts')
		->children()
		->sortBy('date', 'desc');
};
