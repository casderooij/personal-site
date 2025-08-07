<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/martian-mono-light.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>

	<link rel="icon" href="<?= url('favicon.png') ?>" type="image/png">

	<?= vite([
		'assets/css/main.css',
		'assets/ts/index.ts'
	]) ?>

	<title>Cas de Rooij</title>
</head>

<body>

	<header>
		<a href="/">
			<h1>Cas de Rooij -- web developer</h1>
		</a>
		<p>This website showcases projects, prototypes and sketches plotted on a timeline. Each day the items (artifacts) get pushed down a few pixels.</p>
	</header>