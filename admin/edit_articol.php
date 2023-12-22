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
    $articol->titlu = $_POST['titlu'] ;
    $articol->continut = $_POST['continut'] ;
    $articol->data_publicarii = $_POST['data_publicarii'];

    if($articol->update($conn)){
        header("Location: articol.php?id={$articol->id}");
    }
}

?>

<?php
require '../includes/header.php';

?>

    <h2>Edit article</h2>

<?php require "includes/form.php" ?>

<?php require "../includes/footer.php";