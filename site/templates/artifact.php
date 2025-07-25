<?php snippet('head') ?>

<header>
	<a href="/">Cas de Rooij</a>
</header>

<main>

	<?php
	snippet('general-info');
	snippet('timeline');
	?>

	<div class="artifact-detail" id="artifact-detail">
		<?php
		if ($artifact = page('artifacts')->index()->findBy('slug', $page->slug())) {
			return snippet('artifact-details', ['artifact' => $artifact]);
		}
		?>
	</div>
</main>

<?php snippet('footer') ?>