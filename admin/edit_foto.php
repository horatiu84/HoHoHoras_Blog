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

    try {
        if(empty($_FILES)){
            throw new Exception('Invalid upload');
        }
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
                break;
            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('File is to large');
                break;
            default:
                throw new Exception('An error occurred');
        }
        //restrict the file size
        if($_FILES['file']['size'] > 1000000){
            throw new Exception('File is to large');
        }

        //restrict the file type

        $mime_types = ['image/gif','image/png','image/jpeg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo,$_FILES['file']['tmp_name']);

        if (! in_array($mime_type,$mime_types)) {
            throw new Exception('Invalid file type');
        }

        // Move uploaded file and sanitize it

        //Sanitize the uploaded file
        $pathinfo = pathinfo($_FILES['file']['name']);
        $base = $pathinfo['filename'];

        // we want to replace all the unwanted characters with '_'
        $base = preg_replace('/[^a-zA-Z0-9_-]/','_',$base);
        // restrict the number of characters in the file name
        $base = mb_substr($base,0,200);
        $filename=$base.'.'.$pathinfo['extension'];
        // we save the destination location
        $destination = "../uploads/$filename";

        $i = 1;
        while (file_exists($destination)){
            $filename = $base."-$i.".$pathinfo['extension'];
            $destination= "../uploads/$filename";

            $i++;
        }

        if(move_uploaded_file($_FILES['file']['tmp_name'],$destination)){
            $previpus_image = $articol->foto;

            if ( $articol->setImageFile($conn,$filename) ) {
                if ($previpus_image) {
                    unlink("../uploads/$previpus_image");
                }
                header("Location: articol.php?id={$articol->id}");
            };
        } else {
            throw new Exception('Unable to move uploaded filed!');
        };

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>

<?php
require '../includes/header.php';

?>

    <h2>Edit article image</h2>
<?php if(!empty($error)): ?>
    <p><?= $error ?></p>
<?php endif;?>

<?php if ($articol->foto) : ?>
    <img class="edit-foto" src="/uploads/<?=$articol->foto; ?>">
    <a class="btn btn-danger"  href="delete_foto.php?id=<?= $articol->id; ?>">Delete</a>
<?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="file">Image file : </label>
            <input type="file" name="file" id="file">
        </div>
        <button class="btn btn-light">Upload</button>
    </form>

<?php require "../includes/footer.php";