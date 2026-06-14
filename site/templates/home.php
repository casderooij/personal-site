<?php

/** 
 * @var array $grid
 * @var string $currentMonth
 * @var string $prevLink
 * @var string $nextLink
 * @var \Kirby\Cms\Page $page
 * @var \Kirby\Cms\Site $site
 */
?>

<?php snippet('head'); ?>

<header class="px-3 py-2 text-xs">
    <a href="<?= site()->url() ?>">Cas de Rooij</a>
</header>

<main class="p-4">
    <section id="sketches" class="">

        <header class="flex justify-between items-baseline mb-8 pb-4 border-b border-gray-100 font-mono text-xs">
            <nav class="flex items-center gap-4 text-gray-500">
                <a href="<?= $prevLink ?>" class="hover:text-black transition-colors px-2 py-1">&larr;</a>
                <span class="text-gray-900 font-semibold"><?= $currentMonth ?></span>
                <a href="<?= $nextLink ?>" class="hover:text-black transition-colors px-2 py-1">&rarr;</a>
            </nav>
        </header>

        <!-- Calendar Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-8 gap-x-4 gap-y-6">
            <?php foreach ($grid as $item): ?>
                <?php snippet('sketch-thumb', ['item' => $item]) ?>
            <?php endforeach ?>
        </div>
    </section>

</main>


<?php snippet('footer'); ?>