<?php snippet('head') ?>

<?php
$projects = page('projects')
    ->children()
    ->listed()
    ->filterBy('date', '!=', '')
    ->sortBy('date', 'desc');

$pixelsPerDay = (int)($page->pixelsPerDay()->or(40)->value());
$today = new DateTime('today');

$oldestDate = null;
foreach ($projects as $project) {
    $d = new DateTime($project->date()->value());
    if ($oldestDate === null || $d < $oldestDate) {
        $oldestDate = $d;
    }
}

$totalDays = $oldestDate
    ? (int)$today->diff($oldestDate)->days + 60
    : 365;
$containerHeight = $totalDays * $pixelsPerDay;
?>

<div class="min-h-svh font-sans">

    <header class="fixed top-4 left-4 z-10">
        <span class="font-mono text-sm uppercase tracking-widest">Cas de Rooij</span>
    </header>

    <main
        class="relative pl-20 pr-4 pt-20 md:pl-32 md:pr-8"
        style="height: <?= $containerHeight ?>px">

        <div class="absolute top-0 bottom-0 left-12 md:left-20 w-0.5 bg-black"></div>

        <div class="absolute top-20 left-0 right-0 flex items-center">
            <div class="ml-12 md:ml-20 w-8 md:w-10 h-0.5 bg-black shrink-0"></div>
            <time
                class="font-mono text-xs uppercase tracking-wider pl-2"
                datetime="<?= $today->format('Y-m-d') ?>">
                TODAY — <?= $today->format('j M Y') ?>
            </time>
        </div>

        <?php foreach ($projects as $project):
            $projectDate = new DateTime($project->date()->value());
            $diff = $today->diff($projectDate);
            $daysAgo = $diff->invert ? -$diff->days : $diff->days;
            $offset = max(0, $daysAgo) * $pixelsPerDay;

            $imageFile = $project->thumbnail()->toFile();
            $thumb = $imageFile ? $imageFile->thumb('timeline-thumb') : null;
        ?>
            <article
                class="absolute left-0 right-4 md:right-8"
                style="top: calc(5rem + <?= $offset ?>px)"
                data-offset="<?= $offset ?>">

                <div class="absolute top-4 left-[calc(3rem-5px)] md:left-[calc(5rem-5px)] w-2.5 h-2.5 bg-black"></div>
                <div class="absolute top-[calc(1rem+4px)] left-12 md:left-20 w-8 md:w-12 h-0.5 bg-black"></div>

                <a href="<?= $project->url() ?>"
                   class="block pl-20 md:pl-32 no-underline text-black group">
                    <div class="border-2 border-black bg-white md:max-w-sm transition-colors group-hover:bg-black group-hover:text-white">
                        <?php if ($thumb): ?>
                            <div class="aspect-[4/3] overflow-hidden border-b-2 border-black">
                                <img
                                    src="<?= $thumb->url() ?>"
                                    alt="<?= $imageFile->alt()->or($project->title())->esc() ?>"
                                    width="<?= $thumb->width() ?>"
                                    height="<?= $thumb->height() ?>"
                                    class="w-full h-full object-cover block group-hover:invert"
                                    loading="lazy" />
                            </div>
                        <?php endif ?>
                        <div class="p-2 flex flex-col gap-0.5">
                            <time
                                class="font-mono text-[0.7rem] uppercase tracking-wider opacity-60"
                                datetime="<?= $project->date()->value() ?>">
                                <?= $projectDate->format('j M Y') ?>
                            </time>
                            <h2 class="text-base font-bold uppercase tracking-wide m-0"><?= $project->title()->esc() ?></h2>
                        </div>
                    </div>
                </a>

            </article>
        <?php endforeach ?>

    </main>

</div>

<?php snippet('footer') ?>
