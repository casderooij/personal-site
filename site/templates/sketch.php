<?php

/** @var Kirby\Cms\Page $page */

snippet('head');

$siblings = $page->siblings()->unlisted()->sortBy('date', 'asc');
$prev = $page->prev($siblings);
$next = $page->next($siblings);
?>

<header class="mb-4">
    <a href="<?= site()->url() ?>">Cas de Rooij</a>
</header>

<nav class="flex items-center gap-2 mb-16 sm:sticky top-4 z-10">
    <?php if ($prev): ?>
        <a href="<?= $prev->url() ?>" class="text-xs bg-[#dcdcff] px-4 py-1 sm:py-0.5 rounded-full hover:bg-white transition duration-300 ease-in-out">
            &larr; <?= $prev->date()->toDate('F d') ?>
        </a>
    <?php endif ?>

    <?php if ($next): ?>
        <a href="<?= $next->url() ?>" class="text-xs bg-[#dcdcff] px-4 py-1 sm:py-0.5 rounded-full hover:bg-white transition duration-300 ease-in-out">
            <?= $next->date()->toDate('F d') ?> &rarr;
        </a>
    <?php endif ?>
</nav>

<span class="mb-2 inline-block"><?= $page->date()->toDate('F d, Y') ?></span>

<main class="flex flex-col gap-6 items-start">
    <?php
    $images = $page->gallery()->isNotEmpty() ? $page->gallery()->toFiles() : $page->images();
    if ($images->count() > 0):
    ?>
        <?php foreach ($images as $image): ?>
            <figure class="max-w-125 max-h-125 overflow-hidden relative bg-neutral-100 dark:bg-neutral-900">
                <!-- 16x16 Pixelated Placeholder -->
                <img
                    src="<?= $image->thumb('sketch-placeholder')->url() ?>"
                    alt=""
                    aria-hidden="true"
                    class="absolute inset-0 w-full h-full object-cover select-none pointer-events-none"
                    style="image-rendering: pixelated; image-rendering: crisp-edges;">

                <!-- Max 500px sharp image utilizing 'sketch-large' preset -->
                <img
                    src="<?= $image->thumb('sketch-large')->url() ?>"
                    alt="<?= $page->title()->esc() ?>"
                    loading="lazy"
                    onload="this.classList.remove('opacity-0')"
                    class="relative z-10 w-full h-auto object-contain transition-opacity duration-300 opacity-0 block">
            </figure>
        <?php endforeach ?>
    <?php else: ?>
        <p class="text-neutral-500 italic">No image uploaded for this sketch yet.</p>
    <?php endif ?>

    <!-- Tags -->
    <?php if ($page->tags()->isNotEmpty()): ?>
        <div class="mt-4 flex gap-2 flex-wrap">
            <?php foreach ($page->tags()->split(',') as $tag): ?>
                <span class="bg-neutral-200 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 px-2.5 py-0.5 rounded-full text-[10px]">
                    #<?= trim($tag) ?>
                </span>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</main>

<?php snippet('footer'); ?>