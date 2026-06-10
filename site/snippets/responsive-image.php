<?php

/** @var \Kirby\Cms\File|null $image */
if (!$image) return;

$alt = $alt ?? $image->alt()->or($image->page()->title())->esc();
$class = $class ?? 'w-full h-full object-cover';
$lazy = ($lazy ?? true) ? 'lazy' : 'eager';

$srcset = $image->srcset('sketch');
$sizes = $sizes ?? '(max-width: 640px) 100vw, (max-width: 1024px) 33vw, 15vw';
$fallback = $image->thumb('sketch-fallback');
?>
<img
    src="<?= $fallback->url() ?>"
    srcset="<?= $srcset ?>"
    sizes="<?= $sizes ?>"
    alt="<?= $alt ?>"
    loading="<?= $lazy ?>"
    class="<?= $class ?>"
    style="aspect-ratio: <?= $image->width() && $image->height() ? $image->width() . '/' . $image->height() : '1/1' ?>;" />