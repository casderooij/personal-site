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

<main class="float float--left">
    <div class="float-inner main-inner">
        <section class="intro-section">
            <video
                class="intro-video"
                data-src="/assets/one-minute-capture.mp4"
                autoplay playsinline muted loop></video>

            <div class="intro-text">
                <?= $page->introText() ?>
            </div>
        </section>
    </div>
</main>

<?php snippet('footer') ?>