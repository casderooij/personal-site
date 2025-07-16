<?php

return function ($site) {
	return $site
		->find('artifacts')
		->children()
		->listed()
		->sortBy('date', 'desc');
};
