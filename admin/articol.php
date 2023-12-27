<?php
require '../includes/init.php';
Auth::requireLogin();
$conn = require '../includes/db.php';

if (isset($_GET['id'])) {
    $articol = Articol::getById($conn,$_GET['id']);
} else {
    $articol = null;
}


?>
<?php require_once('../includes/header.php'); ?>
    <main>
<?php if ($articol ): ?>
    <article class="articol">
        <h2><?= htmlspecialchars($articol->titlu) ?></h2>
        <?php if($articol->data_publicarii): ?>
            <time><?= $articol->data_publicarii ?></time>
        <?php else : ?>
            Unpublished
        <?php endif; ?>
        <?php if ($articol->foto) : ?>
            <img class="foto" src="<?= ROOT?>/uploads/<?=$articol->foto; ?>">
        <?php endif; ?>
        <p class="continut"><?= htmlspecialchars($articol->continut) ?></p>
    </article>
    <div class="btns">
        <a class="btn btn-secondary" href="edit_articol.php?id=<?=$articol->id?>">Edit</a>
        <a class="btn btn-danger" href="delete_articol.php?id=<?=$articol->id?>">Delete</a>
        <a class="btn light" href="edit_foto.php?id=<?=$articol->id?>">Edit image</a>
    </div>
<?php else: ?>
    <p>Article not found!</p>
<?php endif; ?>
<?php include_once('../includes/footer.php');?>