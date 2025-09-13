<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/hedvig-letters-sans-regular.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>

	<link rel="icon" href="<?= url('favicon.png') ?>" type="image/png">

	<?= vite([
		'assets/css/main.css',
		'assets/ts/index.ts'
	]) ?>

	<title>Cas de Rooij - creative web developer</title>
</head>

<body>