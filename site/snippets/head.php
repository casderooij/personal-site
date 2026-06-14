<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/commit-mono-variable.woff2') ?>"
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

<body class="font-mono min-h-screen bg-[#f3f3f3] text-neutral-900 selection:bg-neutral-900 selection:text-white">