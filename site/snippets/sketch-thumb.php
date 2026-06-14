<?php

/**
 * @var array $item
 */

$sketch = $item['sketch'] ?? null;
$day    = $item['day'];
$paddedDay = sprintf('%02d', $day);

$image = null;
if ($sketch && $sketch->gallery()->isNotEmpty()) {
    $image = $sketch->gallery()->toFile();
}
if ($sketch && !$image) {
    $image = $sketch->image();
}
?>

<?php if ($sketch && $image): ?>
    <a href="<?= $sketch->url() ?>" class="group flex flex-col justify-between aspect-square text-left no-underline">
        <span class="font-mono text-[10px] text-gray-900">(<?= $paddedDay ?>)</span>

        <!-- Wrapper with relative positioning -->
        <div class="mt-1 w-full aspect-square overflow-hidden bg-gray-100 relative">

            <!-- 16x16 Pixelated Placeholder -->
            <img
                src="<?= $image->thumb('sketch-placeholder')->url() ?>"
                alt=""
                aria-hidden="true"
                class="absolute inset-0 w-full h-full object-cover select-none pointer-events-none"
                style="image-rendering: pixelated; image-rendering: crisp-edges;">

            <!-- Sharp Main Image (fades in once loaded) -->
            <img
                src="<?= $image->thumb('sketch-thumb')->url() ?>"
                alt="<?= $sketch->title()->esc() ?>"
                loading="lazy"
                onload="this.classList.remove('opacity-0')"
                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 opacity-0">

        </div>
    </a>
<?php else: ?>
    <div class="flex flex-col justify-between aspect-square text-left">
        <span class="font-mono text-[10px] text-gray-300">(<?= $paddedDay ?>)</span>
        <div class="mt-1 w-full aspect-square"></div>
    </div>
<?php endif ?>