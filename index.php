
<?php
require 'includes/init.php';
$conn = require 'includes/db.php';

/* salvam intr-o variabila $articole, rezultatele venite din metoda getAll
 a clasei Articol. Din cauza ca aceasta metoda este statica, nu face referire
 la un obiect(articol) anume si se foloseste  fara sa fie
 nevoie de o instantiere pentru clasa respectiva.
 Mai multe despre static si metode statice :
 https://www.php.net/manual/en/language.oop5.static.php
 https://www.w3schools.com/php/php_oop_static_methods.asp
 array-ul $articole o sa contina toate articolele gasite in baza de date

*/
//$articole=Articol::getAll($conn);


// vom folosi o noua metoda pentru a avea paginatie pe pagina, dar o sa las comentate explicatiile de mai sus,
// daca nu se doreste partea de paginare
$paginator = new Paginator($_GET['page'] ?? 1,4,Articol::getTotal($conn,true));

$articole = Articol::getPage($conn,$paginator->limit,$paginator->offset,true);


?>
<?php require 'includes/header.php'; ?>
<?php
/*
  * Prima data o sa facem o verificare :
  * daca in arrayul $articole nu exista nici un articol, cu
  * alte cuvinte este gol : afisam un mesaj cu acest fapt
  * Daca in schimb $articole nu este gol, luam din acest array
  * datele de care avem nevoie.
  * Prima data vom face un loop(forEach) si din fiecare articol gasit,
  * putem prelua datele necesare .
 * Resurse pentru forEach : https://flexiple.com/php/php-foreach
 *
 * mai multe resurse despre format la data : https://www.php.net/manual/en/datetime.format.php
  */
?>
<?php if(empty($articole)) : ?>
<p>Nu a fost gasit nici un articol!</p>
<?php else: ?>
        <div class="container articole">

        <?php foreach ($articole as $articol): ?>
            <div  class="card" style="width: 30rem;">
                <img src="uploads/photos/HoHoHora.png" class="card-img-top" alt="ceva poza">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($articol['titlu']);  ?></h5>
                    <p class="card-text"> Published on : 
                        <time datetime="<?= $articol['data_publicarii'] ?>">
                            <?php $datetime = new DateTime($articol['data_publicarii']);
                                  echo $datetime->format("j F, Y")
                            ?>
                    </p>
                    <a href="articol.php?id=<?=$articol['id'] ?>" class="btn btn-light">Read more</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php require 'includes/paginare.php' ?>
<?php endif; ?>


<?php require 'includes/footer.php'; ?>





