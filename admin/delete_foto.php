<?php
require '../includes/init.php';

Auth::requireLogin();
$conn = require '../includes/db.php';

if (isset($_GET['id'])) {

    $articol = Articol::getById($conn,$_GET['id']);

    if (!$articol) {
        die("article not found");
    }
} else {
    die("id not supplied, article not found");
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $previpus_image = $articol->foto;

    if ( $articol->setImageFile($conn,null) ) {
        if ($previpus_image) {
            unlink("../uploads/$previpus_image");
        }
        header("Location: articol.php?id={$articol->id}");
    };
}

?>

<?php
require '../includes/header.php';

?>

    <h2>Delete article image</h2>

<?php if ($articol->foto) : ?>
    <img class="edit-foto" src="/uploads/<?=$articol->foto; ?>">

<?php endif; ?>

    <form method="post" >
        <p>Are you sure?</p>
        <button class="btn btn-danger">Delete</button>
        <a class="btn light" href="edit_foto.php?id=<?= $articol->id ?>">Cancel</a>
    </form>

<?php require "../includes/footer.php";