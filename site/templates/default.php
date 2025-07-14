<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/martian-grotesk-std-lt.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>

	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/newsreader-regular.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>

	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/martian-mono-light.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>

	<?= vite([
		'assets/css/main.css',
		'assets/ts/index.ts'
	]) ?>

	<title>Cas de Rooij</title>
</head>

<body>
	<header>
		<div class="header-content">
			<a href="/"><?= $page->title() ?></a>
		</div>
	</header>

	<main>
		<div class="timeline">

			<div class="stack-wrapper">
				<?php snippet('slider', ['slides' => $site->Homepagecarousel()->toStructure()]) ?>
			</div>

			<section>
				<?php $artifacts = site()->find('artifacts')->children()->listed(); ?>

				<?php foreach ($artifacts as $artifact): ?>
					<?= $artifact->title() ?>
				<?php endforeach ?>
			</section>

		</div>
	</main>
</body>

</html>