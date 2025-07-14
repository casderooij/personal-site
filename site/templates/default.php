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
		<a href="/"><?= $page->title() ?></a>

		<!-- <div class="stack-wrapper">
					<?php snippet('slider', ['slides' => $site->Homepagecarousel()->toStructure()]) ?>
				</div> -->
	</header>

	<main>




		<section class="timeline">
			<?php date_default_timezone_set('Europe/Amsterdam'); ?>
			<time class="timeline__today"><?= date('D M j') ?></time>

			<?php $artifacts = site()->find('artifacts')->children()->listed(); ?>

			<?php foreach ($artifacts as $artifact): ?>
				<!-- <?= $artifact->title() ?> -->
			<?php endforeach ?>
		</section>


	</main>
</body>

</html>