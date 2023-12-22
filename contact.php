<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

require 'includes/init.php';

$email = '';
$subject = '';
$message = '';
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$errors = [];

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
$errors[] = 'Please enter a valid email address';
}

if($subject == '') {
$errors[]='Please enter a subject';
}

if($message =='') {
$errors[]='Please enter a message';
}

if (empty($errors)) {

$mail = new PHPMailer(true);

try {
$mail->isSMTP();
$mail->Host = SMTP_HOST;
$mail->SMTPAuth = true;
$mail->Username = SMTP_USER;
$mail->Password = SMTP_PASSWORD;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('catalin.ciprian84@gmail.com');
$mail->addAddress('catalin.ciprian84@gmail.com');
$mail->addReplyTo($email);
$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

$sent = true;
} catch (Exception $e) {
$errors[]= $mail->ErrorInfo;
}

}

}

?>

<?php require 'includes/header.php'; ?>

<h2>Contact</h2>

<?php if($sent) : ?>
    <p>Message sent</p>
<?php else: ?>

    <?php if (! empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>



    <form method="post" >
        <div class="form-group">
            <label for="email">Your email</label>
            <input class="form-control" id="email" name="email" type="email" placeholder="Your email" value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input class="form-control" id="subject" name="subject" type="text" placeholder="Subject" value="<?= htmlspecialchars($subject) ?>">
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea  class="form-control" id="message" name="message"  placeholder="Your message"><?= htmlspecialchars($message) ?></textarea>
        </div>

        <button class="btn btn-light">Send</button>
    </form>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>