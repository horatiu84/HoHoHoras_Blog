<?php
require '../includes/init.php';
Auth::requireLogin();
$conn = require '../includes/db.php';

if (isset($_GET['id'])) {
    $articol = Articol::getById($conn,$_GET['id']);

    if (!$articol) {
        die("Article not found");
    }

} else {
    die("id not supplied, article not found");
}

if($_SERVER["REQUEST_METHOD"] === "POST") {

    if($articol->delete($conn)){
        header("Location: index.php");
        exit;
    }
}
?>

<?php require '../includes/header.php'; ?>
    <h2>Delete article</h2>

    <p>Are you sure ?</p>
    <div class="delete-article">
        <form method="post" >
            <button class="btn btn-danger">Delete</button>
        </form>
        <a class="btn light" href="articol.php?id=<?=$articol->id?>">Cancel</a>
    </div>

<?php require  '../includes/footer.php' ?>