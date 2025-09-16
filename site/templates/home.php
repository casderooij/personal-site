<?php $encodedIntroVideos = json_encode($page->introVideos()->toStructure()->map(function ($item) {
    $itemArray = $item->toArray();
    unset($itemArray['video'], $itemArray['id']);

    $video = $item->video()->toFile();
    $itemArray['url'] = $video ? $video->url() : null;

    return $itemArray;
}));
?>

<?php snippet('head') ?>

<header class="top-header">
    <div class="top-header-heading">
        <img src="favicon.png" width="20" />
        <h1>creative web developer</h1>
    </div>

    <div id="sphere-container" class="sphere-container" data-videos="<?= htmlspecialchars($encodedIntroVideos, ENT_QUOTES, 'UTF-8') ?>">
        <div id="selected-video-container" class="selected-video-container">
            <div id="selected-video-title" class="selected-video-title"></div>
        </div>
    </div>
    <div id="sphere-videos-container" class="sphere-videos-container"></div>
</header>

<button id="scroll-down-to-main-button" class="scroll-down-button">Scroll down for info</button>

<main>
    <section class="float float--left" style="margin-bottom: 1rem;">
        <div class="float-inner float-inner--yellow">
            <video
                class="intro-video"
                data-src="/assets/one-minute-capture.mp4"
                autoplay playsinline muted loop></video>
            <div class="intro-text">
                <?= $page->introText() ?>
            </div>
        </div>
    </section>

    <?php
    $projects = $page->projects()->toStructure();

    foreach ($projects as $project):
        $projectPage = $project->page()->toPage();
    ?>
        <section class="float float--<?= $project->position() ?>">
            <div class="float-inner project" style="background-color: <?= $project->backgroundColor() ?>;">
                <div class="project-tags">
                    <?php foreach ($projectPage->tags()->split() as $tag): ?>
                        <span class="project-tag"><?= $tag ?></span>
                    <?php endforeach ?>
                </div>

                <h2><?= $projectPage->title() ?></h2>
                <?php snippet('gallery', ['media' => $projectPage->media()->toFiles()]) ?>
                <div class="project-description">
                    <?= $projectPage->description() ?>
                </div>
            </div>
        </section>
    <?php endforeach ?>
</main>

<?php snippet('footer') ?>