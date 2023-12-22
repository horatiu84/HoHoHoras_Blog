<?php
require 'includes/init.php';

$conn = require 'includes/db.php';

if (isset($_GET['id'])) {

    $article = Articol::getById($conn,$_GET['id']);
} else {
    $article = null;
}


?>
<?php require_once('includes/header.php'); ?>
    <main>
<?php if ($article ): ?>
    <article class="articol">
        <h2><?= htmlspecialchars($article->titlu) ?></h2>
        <time datetime="<?= $article->data_publicarii ?>">
            <?php
            $datetime = new DateTime($article->data_publicarii);
            echo $datetime->format("j F, Y")
            ?>
        </time>
        <?php if ($article->foto) : ?>
            <img class="foto" src="/uploads/<?=$article->foto; ?>">
        <?php endif; ?>
        <p class="continut"><?= htmlspecialchars($article->continut) ?></p>
    </article>
<?php else: ?>
    <p>Article not found!</p>

<?php endif; ?>

<?php include_once('includes/footer.php');?>