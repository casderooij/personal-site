<?php
snippet('head');
$artifacts = page('artifacts')->children()->sortBy('date', 'desc');
?>

<div class="min-h-svh font-sans">
    <header class="fixed top-4 left-4 z-10">
        <span class="">Cas de Rooij</span>
    </header>

    <main class="relative pl-20 pr-4 pt-20 md:pl-32 md:pr-8">

        <?php foreach ($artifacts as $artifact):
            $date = $artifact->date()->value(); ?>
            <article>
                <time
                    class="font-mono text-[0.7rem] opacity-60"
                    datetime="<?= $date ?>">
                    <?= $date ?>
                </time>
                <h2 class="text-base font-bold"><?= $artifact->title() ?></h2>
            </article>
        <?php endforeach; ?>
    </main>
</div>

<?php snippet('footer'); ?>