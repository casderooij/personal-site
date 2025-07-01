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
	<link
		rel="preload"
		href="<?= vite()->asset('assets/fonts/whois-mono.woff2') ?>"
		as="font"
		type="font/woff2"
		crossorigin>

	<?= vite([
		'assets/style.css',
		'assets/index.js'
	]) ?>

	<title>Cas de Rooij</title>
</head>

<body>
	<header>
		<a href="/"><?= $page->title() ?></a>
	</header>
</body>

</html>