<?php
/*
 * Pentru a nu importa mereu clasele in fisierele php, unde avem nevoie
 * de ele, exista o functie in PHP care o sa incarce automat aceste clase.
 *
 * Vom folosi functia spl_autoload_register(). Mai multe info se pot gasi in
 * linkul de mai jos.
 *
 * resurse : https://www.php.net/manual/en/function.spl-autoload-register.php
 */

/*
 * Daca avem o cale : /exemplu/www/includes/ceva.php
 *  __DIR__ - o sa returneze folderul unde se afla fisierul nostru : /exemplu/www/includes
 *
 * dirname(__DIR__) - o sa returneze fisierul parinte : /exemplu/www
 */
//           https://www.php.net/manual/en/function.dirname.php

spl_autoload_register(function ($class){
    require dirname(__DIR__)."/classes/{$class}.php";
});
/*
 * O sa folosesc o constanta pentru cale, in caz ca vreau sa redenumesc
 * folderul in viitor, sa fac o singura modificare
 */
const ROOT = '/HoHoHoras_Blog';


session_start();

require dirname(__DIR__).'/config.php';
