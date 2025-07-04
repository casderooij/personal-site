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
		<section class="grid-2-col">
			<p class="body-text">Fugiat sint amet sunt veniam fugiat exercitation. Cupidatat aliquip adipisicing ullamco qui. Non exercitation eu nulla amet incididunt ad exercitation. Cillum esse anim cupidatat non sit velit. Ea Lorem velit elit enim nostrud sunt incididunt commodo pariatur est.</p>
			<div class="stack-wrapper">
				<?php snippet('project-thumbnails') ?>
			</div>
		</section>
	</main>
</body>

</html>