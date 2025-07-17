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

	<link rel="icon" href="<?= url('favicon.png') ?>" type="image/png">

	<?= vite([
		'assets/css/main.css',
		'assets/ts/index.ts'
	]) ?>

	<title>Cas de Rooij</title>
</head>

<body>
	<header>
		<a href="/"><?= $page->title() ?></a>
	</header>

	<main>
		<div class="info">
			<div class="info-item"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6 3.5C6 2.67157 6.67157 2 7.5 2C8.32843 2 9 2.67157 9 3.5C9 4.32843 8.32843 5 7.5 5C6.67157 5 6 4.32843 6 3.5ZM8 5.94999C9.14112 5.71836 10 4.70948 10 3.5C10 2.11929 8.88071 1 7.5 1C6.11929 1 5 2.11929 5 3.5C5 4.70948 5.85888 5.71836 7 5.94999V13.5C7 13.7761 7.22386 14 7.5 14C7.77614 14 8 13.7761 8 13.5V5.94999Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
				</svg><span><?= $site->homePage()->Location() ?></span></div>

			<div class="info-item">
				<?php $githubObject = $site->homePage()->Github()->toObject(); ?>
				<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M7.49933 0.25C3.49635 0.25 0.25 3.49593 0.25 7.50024C0.25 10.703 2.32715 13.4206 5.2081 14.3797C5.57084 14.446 5.70302 14.2222 5.70302 14.0299C5.70302 13.8576 5.69679 13.4019 5.69323 12.797C3.67661 13.235 3.25112 11.825 3.25112 11.825C2.92132 10.9874 2.44599 10.7644 2.44599 10.7644C1.78773 10.3149 2.49584 10.3238 2.49584 10.3238C3.22353 10.375 3.60629 11.0711 3.60629 11.0711C4.25298 12.1788 5.30335 11.8588 5.71638 11.6732C5.78225 11.205 5.96962 10.8854 6.17658 10.7043C4.56675 10.5209 2.87415 9.89918 2.87415 7.12104C2.87415 6.32925 3.15677 5.68257 3.62053 5.17563C3.54576 4.99226 3.29697 4.25521 3.69174 3.25691C3.69174 3.25691 4.30015 3.06196 5.68522 3.99973C6.26337 3.83906 6.8838 3.75895 7.50022 3.75583C8.1162 3.75895 8.73619 3.83906 9.31523 3.99973C10.6994 3.06196 11.3069 3.25691 11.3069 3.25691C11.7026 4.25521 11.4538 4.99226 11.3795 5.17563C11.8441 5.68257 12.1245 6.32925 12.1245 7.12104C12.1245 9.9063 10.4292 10.5192 8.81452 10.6985C9.07444 10.9224 9.30633 11.3648 9.30633 12.0413C9.30633 13.0102 9.29742 13.7922 9.29742 14.0299C9.29742 14.2239 9.42828 14.4496 9.79591 14.3788C12.6746 13.4179 14.75 10.7025 14.75 7.50024C14.75 3.49593 11.5036 0.25 7.49933 0.25Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
				</svg>
				<a target="_blank" href="<?= $githubObject->link()->toUrl() ?>"><span><?= $githubObject->label() ?></span></a>
			</div>
		</div>

		<section class="intro">
			<p class="intro__text">
				<?= $site->homePage()->introText() ?>
			</p>
		</section>

		<?php snippet('timeline') ?>
	</main>
</body>

</html>