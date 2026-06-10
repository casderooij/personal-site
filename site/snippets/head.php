<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/uncut-sans-regular.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>
	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/fragment-mono-regular.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>

	<link rel="icon" href="<?= url('favicon.ico') ?>" type="any">
	<link rel="icon" href="<?= url('favicon.svg') ?>" type="image/svg+xml">

	<?= vite([
		'assets/css/main.css',
		'assets/ts/index.ts'
	]) ?>

	<title>Cas de Rooij</title>
</head>

<body class="font-sans">