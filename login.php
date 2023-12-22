<?php

require 'includes/init.php';

require 'includes/header.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = require 'includes/db.php';
    if(Admin::authenticate($conn,$_POST['numeAdmin'],$_POST['parola'])){
        Auth::login();
        header('Location: index.php');
    } else {
        $error = "Incorrect credentials";
    }
}



?>

    <h2>Login</h2>
<?php if(! empty($error)) :?>
    <p><?= $error ?></p>
<?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="numeAdmin">Username</label>
            <input name="numeAdmin" id="numeAdmin" class="form-control">
        </div>

        <div class="form-group">
            <label for="parola">Password</label>
            <input type="password" name="parola" id="parola" class="form-control">
        </div>

        <button  class="btn btn-light">Log in</button>
    </form>

<?php require 'includes/footer.php';?>