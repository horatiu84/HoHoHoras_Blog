<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1,5,Articol::getTotal($conn));

$articole = Articol::getPage($conn,$paginator->limit,$paginator->offset);

?>

<?php require_once('../includes/header.php'); ?>

    <h2>Administration</h2>

    <p> <a href="creaza_articol.php">New article</a> </p>

<?php if (empty($articole)): ?>
    <p>No articles found!</p>
<?php else: ?>
    <table class="table table-striped table-hover">
        <thead class="table-secondary">
        <th>Title</th>
        <th>Published</th>
        </thead>
        <tbody>


        <?php foreach ($articole as $articol): ?>
            <tr class="table-secondary">
                <td>
                    <a href="articol.php?id=<?= $articol['id']?>" ><?= htmlspecialchars($articol['titlu']) ?></a>
                </td>
                <td>
                    <?php if($articol['data_publicarii']): ?>
                        <time><?= $articol['data_publicarii'] ?></time>
                    <?php else : ?>
                        Unpublished
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php require '../includes/paginare.php';?>
<?php endif; ?>
<?php include_once('../includes/footer.php');?>