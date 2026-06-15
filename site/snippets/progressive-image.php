<?php

/**
 * @var Kirby\Cms\File $image
 * @var string $thumbPreset (e.g. 'sketch-thumb' or 'sketch-large')
 * @var string $alt
 * @var string|null $class
 */

$image = $image ?? null;
$thumbPreset = $thumbPreset ?? 'sketch-thumb';
$alt = $alt ?? '';
$class = $class ?? '';
?>

<?php if ($image): ?>
    <!-- 16x16 Pixelated Placeholder -->
    <img
        src="<?= $image->thumb('sketch-placeholder')->url() ?>"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 w-full h-full object-cover select-none pointer-events-none"
        style="image-rendering: pixelated; image-rendering: crisp-edges;">

    <!-- Sharp Main Image (fades in once loaded) -->
    <img
        src="<?= $image->thumb($thumbPreset)->url() ?>"
        alt="<?= esc($alt) ?>"
        loading="lazy"
        onload="this.classList.remove('opacity-0')"
        class="<?= $class ?> transition-opacity duration-300 opacity-0">
<?php endif ?>
