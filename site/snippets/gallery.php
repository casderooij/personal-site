<div class="gallery <?= $media->count() == 1 ? 'gallery--not-interactive' : '' ?>" data-items-count="<?= $media->count() ?>">
    <div class="gallery-media-container">
        <?php foreach ($media as $item):
            $type = $item->type();
            $thumb = $item->thumb('project');
        ?>
            <?php if ($type == 'image'): ?>
                <div class="media-wrapper" style="--aspect-ratio: <?= $item->aspectratio() ?>">

                    <img
                        src="<?= $thumb->url() ?>"
                        alt="<?= $item->alt()->or($item->title())->esc() ?>"
                        width="<?= $thumb->width() ?>"
                        height="<?= $thumb->height() ?>"
                        loading="lazy" />
                </div>
            <?php elseif ($type == 'video'): ?>
                <div class="media-wrapper" style="--aspect-ratio: <?= $item->aspectratio() ?>">
                    <video
                        style="--aspect-ratio: <?= $item->aspectratio() ?>"
                        data-src="<?= $item->url() ?>"
                        loop
                        muted
                        playsinline
                        autoplay
                        preload="auto"></video>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <?php if ($media->count() > 1): ?>
        <div class="gallery-indicator">
            <?php foreach ($media as $item): ?><?= $media->indexOf($item) == 0 ? '*' : '-' ?><?php endforeach ?>
        </div>
    <?php endif ?>
</div>