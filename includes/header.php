<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ho-Ho-Hora's Blog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@100;400;600&family=Inter:wght@300;400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="container">
        <header>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>">Home</a></li>
                    <?php if (Auth::isLoggedIn()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/admin/index.php">Admin</a> </li>
                        <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/logout.php">Log out</a> </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/login.php">Login</a> </li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/contact.php">Contact</a></li>
                </ul>
            </nav>
        </header>
        <img class="main-photo" src="<?=ROOT?>/uploads/photos/HoHoHora.png" alt="Hora's 2 blog">
