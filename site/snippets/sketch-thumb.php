<?php

/**
 * @var array $item
 */

$sketch = $item['sketch'] ?? null;
$day    = sprintf('%02d', $item['day']);

$image = null;
if ($sketch && $sketch->gallery()->isNotEmpty()) {
    $image = $sketch->gallery()->toFile();
}
if ($sketch && !$image) {
    $image = $sketch->image();
}
?>

<?php if ($sketch && $image): ?>
    <a href="<?= $sketch->url() ?>" class="flex flex-col justify-between aspect-square text-left no-underline text-[10px]">
        <span>[<?= $day ?>]</span>

        <div class="mt-1 w-full aspect-square overflow-hidden relative">
            <?php snippet('progressive-image', [
                'image'       => $image,
                'thumbPreset' => 'sketch-thumb',
                'alt'         => $sketch->title(),
                'class'       => 'absolute inset-0 w-full h-full object-cover z-10'
            ]) ?>
        </div>
    </a>
<?php else: ?>
    <div class="flex flex-col justify-between aspect-square text-left">
        <span class="text-gray-300">[<?= $day ?>]</span>
        <div class="mt-1 w-full aspect-square"></div>
    </div>
<?php endif ?>
