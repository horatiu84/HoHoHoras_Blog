<?php

/**
 * Clasa pentru autentificarea adminului
 *
 * Login
 */
class Auth {
    /**
     * O sa returneze statusul de logare
     * @return boolean True daca adminul este logat, false daca nu
     */
    public static function isLoggedIn(){
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }

    /**
     * Daca userul nu este logat, apicatia o sa fie oprita cu mesaj de eroare
     *
     * @return void
     */
    public  static function requireLogin(){
        if (!static::isLoggedIn()) {
            die("unauthorised");}
    }

    /**
     * Se face logarea, folosindu-ne de sesiuni
     * @return void
     * mai multe despre sesiuni : https://www.w3schools.com/php/php_sessions.asp
     */
    public static function login(){
        // mai multe despre session_regenerate_id : https://www.plus2net.com/php_tutorial/session_id.php#
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;
    }

    /**
     * Metoda pentru delogare - session_destroy()
     * @return void
     *
     * mai multe despre aceasta functie : https://www.php.net/manual/en/function.session-destroy.php
     */
    public static function logout(){
        $_SESSION=[];

        if(ini_get("session.use_cookies")){
            $parms = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time()-42000,
                $parms["path"],
                $parms["domain"],
                $parms["secure"],
                $parms["httponly"]
            );
        }
        session_destroy();
    }
}