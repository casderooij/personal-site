<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?= vite([
		'assets/style.css',
		'assets/index.js'
	]) ?>

	<title>Cas de Rooij</title>
</head>

<body>
	<a href="/">Home</a>
	<a href="/test">Test</a>

	<h1><?= $page->title() ?></h1>
</body>

</html>