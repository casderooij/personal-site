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
		<section class="head-section">
			<div class="head-section__item">
				<p class="head-text">As a web developer with a background in design, I enjoy crafting and bringing unique & playful concepts to life for a wide audience.</p>
			</div>
			<div class="head-section__item">
				<div class="stack-wrapper">
					<?php snippet('project-thumbnails') ?>
				</div>
			</div>
		</section>
	</main>
</body>

</html>