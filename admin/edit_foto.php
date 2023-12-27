<?php
require '../includes/init.php';

// resurse pentru a uploada fisiere in php : https://code.tutsplus.com/how-to-upload-a-file-in-php-with-example--cms-31763t
// https://www.geeksforgeeks.org/how-to-upload-a-file-in-php/

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
// mai multe resurse despre variabila superglobala $_FILES : https://www.tutorialspoint.com/php-files

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // pentru inceput o sa verificam daca avem erori pt fisierul care il uploadam
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
        //Sa punem o restrictie de aproximativ 1Mb pentru fisierul incarcat
        if($_FILES['file']['size'] > 1000000){
            throw new Exception('File is to large');
        }

        //sa punem o restrictie pentru tipul de fisier incarcat
        $mime_types = ['image/gif','image/png','image/jpeg'];

        // functia finfo_open returneaza informatii despre un fisier
        //resurse : https://www.php.net/manual/en/function.finfo-file.php
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo,$_FILES['file']['tmp_name']);

        if (! in_array($mime_type,$mime_types)) {
            throw new Exception('Invalid file type');
        }

        // Mutam fisierul uploadat si il sanitizam

        //sanitizam fisierul uploadat

        // functia pathinfo() - returneaza informatii despre o cale unde se gaseste un fisier
        // mai multe resurse : https://www.php.net/manual/en/function.pathinfo.php
        $pathinfo = pathinfo($_FILES['file']['name']);
        $base = $pathinfo['filename'];

        // vrem sa inlocuim caracterele speciale cu  '_'
        // mai multe despre functia preg_replace : https://reintech.io/blog/understanding-implementing-php-preg-replace-function
        $base = preg_replace('/[^a-zA-Z0-9_-]/','_',$base);
        // putem restrictiona numarul de caractere din denumirea fisierului uploadat
        // resurse pt functia mb_substr : https://www.php.net/manual/en/function.mb-substr.php
        $base = mb_substr($base,0,200);
        $filename=$base.'.'.$pathinfo['extension'];

        // salvam locatia pentru destinatie
        $destination = "../uploads/$filename";

        $i = 1;
        // daca mai exista cumva un fisier cu aceiasi denumire, o sa-i modificam putin denumirea, adaugand o cifra
        while (file_exists($destination)){
            $filename = $base."-$i.".$pathinfo['extension'];
            $destination= "../uploads/$filename";

            $i++;
        }

        if(move_uploaded_file($_FILES['file']['tmp_name'],$destination)){
            $previpus_image = $articol->foto;

            if ( $articol->setImageFile($conn,$filename) ) {
                // daca exista o imagine anterioara la acest articol, aceasta o sa fie stearsa si inlocuita cu cea noua
                if ($previpus_image) {
                    // functia unlink sterge un fisier : https://www.php.net/manual/en/function.unlink.php
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