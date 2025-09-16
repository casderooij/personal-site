<?php $encodedIntroVideos = json_encode($page->introVideos()->toStructure()->map(function ($item) {
    $itemArray = $item->toArray();
    unset($itemArray['video'], $itemArray['id']);

    $video = $item->video()->toFile();
    $itemArray['url'] = $video ? $video->url() : null;

    return $itemArray;
}));
?>

<div id="sphere-container" class="sphere-container" data-videos="<?= htmlspecialchars($encodedIntroVideos, ENT_QUOTES, 'UTF-8') ?>">
    <div id="selected-video-container" class="selected-video-container">
        <div id="selected-video-title" class="selected-video-title"></div>
    </div>
</div>
<div id="sphere-videos-container" class="sphere-videos-container"></div>