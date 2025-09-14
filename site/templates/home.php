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


<!-- <button id="scroll-down-to-main-button" class="scroll-down-button">Scroll down</button> -->

<main>
    <div class="inner"></div>
</main>

<footer></footer>

<!-- <main>
    <section class="intro-section">
        <div class="intro-content">
            <p>
                I am a web developer working at the intersection of user experience,
                design and technology. Since 2018, I've been building solutions such
                as booking flows, data dashboards, micro sites, 3D animations, and
                much more.
            </p>

            <p>
                I gain knowledge from working on professional projects as well as
                from personal experiments. The insights and experiences I gain from
                personal projects often flow back into my client-based work.
            </p>

            <p>
                I find the web a beautiful, accessible canvas for telling stories,
                giving insights and providing tools. Lots of things can be build for
                the web, and I'm here to do just that!
            </p>
        </div>

        <div class="intro-links">
            <?php snippet('external-link', ['label' => 'Github', 'url' => 'https://github.com/casderooij']) ?>
            <?php snippet('external-link', ['label' => 'Bluesky', 'url' => 'https://bsky.app/profile/casderooij.nl']) ?>
            <?php snippet('external-link', ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/cas-de-rooij-86374861/']) ?>
        </div>
    </section>
</main> -->

<?php snippet('footer') ?>