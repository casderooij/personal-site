<?php $externalLinks = $site->footerLinks()->toStructure(); ?>

<footer class="p-4">
    <?php foreach ($externalLinks as $link):
        snippet('external-link', ['label' => $link->label(), 'url' => $link->url()]);
    endforeach  ?>
</footer>
</body>

</html>