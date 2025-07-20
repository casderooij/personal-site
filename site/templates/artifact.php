<?php

if ($artifact = $site->index()->findBy('slug', $page->slug())) {
	echo $artifact->title();
}
