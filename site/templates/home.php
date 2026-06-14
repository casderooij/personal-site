<?php

/** 
 * @var array $grid
 * @var string $currentMonth
 * @var string $prevLink
 * @var string $prevMonth
 * @var string $nextLink
 * @var string $nextMonth
 */

snippet('head');
?>

<header class="mb-4">
    <a href="<?= site()->url() ?>">Cas de Rooij</a>
</header>

<nav class="flex items-center gap-2 mb-16 sticky top-4 z-10">
    <a href="<?= $prevLink ?>" class="text-xs bg-[#dcdcff] px-4 py-1 sm:py-0.5 rounded-full hover:bg-white transition duration-300 ease-in-out">&larr; <?= $prevMonth ?></a>
    <a href="<?= $nextLink ?>" class="text-xs bg-[#dcdcff] px-4 py-1 sm:py-0.5 rounded-full hover:bg-white transition duration-300 ease-in-out"><?= $nextMonth ?> &rarr;</a>
</nav>

<span class="mb-2 inline-block"><?= $currentMonth ?></span>

<main class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-x-4 gap-y-6">
    <?php foreach ($grid as $item): ?>
        <?php snippet('sketch-thumb', ['item' => $item]) ?>
    <?php endforeach ?>
</main>

<?php snippet('footer'); ?>