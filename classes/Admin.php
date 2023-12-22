<?php

/**
 * Clasa pentru administrator
 *
 * Persoana care se poate loga si face modificari pe site
 */
class Admin {
    public $id;
    public $nume;
    public $parola;
    /**
     * Face autentificarea adminului, dupa nume si parola
     * @param string $nume numele adminului
     * @param string $parola parola adminului
     * @return bool True daca sunt corecte credentialele, null daca nu
     */
    public static function authenticate($conn,$nume,$parola){
        $sql = "SELECT *
               FROM admin
               WHERE nume = :nume";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':nume', $nume, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS,'Admin');
        $stmt->execute();



        if($admin = $stmt->fetch()) {
            return password_verify($parola,$admin->parola);
        }

    }
}