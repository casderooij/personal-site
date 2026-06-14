<?php $externalLinks = site()->footerLinks()->toStructure(); ?>

<footer class="mt-16">
    <?php foreach ($externalLinks as $link): ?>
        <a class="underline text-[blue]" href="<?= $link->url() ?>"><?= $link->label() ?></a>
    <?php endforeach  ?>
</footer>
</body>

</html>