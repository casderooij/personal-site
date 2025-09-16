<?php snippet('head') ?>

<header class="top-header">
    <div class="top-header-heading">
        <img src="favicon.png" width="20" />
        <h1>creative web developer</h1>
    </div>

    <?php snippet('video-sphere') ?>
</header>

<button id="scroll-down-to-main-button" class="scroll-down-button">Scroll down</button>

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

    <div class="project-sections">
        <?php snippet('project-sections') ?>
    </div>
</main>

<?php snippet('footer') ?>