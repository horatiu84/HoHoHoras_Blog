<?php
require '../includes/init.php';


Auth::requireLogin();


$articol = new Articol();

$conn = require '../includes/db.php';


if ($_SERVER['REQUEST_METHOD'] == "POST"){


    $articol->titlu = $_POST['titlu'];
    $articol->continut=$_POST['continut'];
    $articol->data_publicarii = $_POST['data_publicarii'];



    if($articol->create($conn)) {
        header("Location: articol.php?id={$articol->id}");
    }

}

?>

<?php require '../includes/header.php'; ?>

    <h2>New article</h2>

<?php require "includes/form.php" ?>

<?php require '../includes/footer.php';