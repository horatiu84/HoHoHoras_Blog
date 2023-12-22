<?php

/**
 * Clasa Articol, este o clasa pe care o vom folosi
 * pentru a manipularea(CRUD) a unui articol
 */
class Articol
{
    /* aici vom pune toate proprietatiile clasei, unde trebuie sa se regaseasca neaparat si
       coloanele pentru tabelul Articol din baza de date (id, titlu,continut,data_publicarii,foto)
    */
    /**
     * ID-ul pentru un articol
     * @var integer
     */
    public $id;
    /**
     * titlul unui articol
     * @var string
     */
    public $titlu;
    /**
     * Continutul unui articol
     * @var string
     */
    public $continut;
    /**
     * Data la care a fost publicat un articol(daca exista, poate sa fie si null)
     * @var string sau null
     */
    public $data_publicarii;
    /**
     * Fotografie pentru articolul respectiv, daca exista
     * @var string sau null
     */
    public $foto;

    /**
     * Metoda pentru a extrage toate articolele din baza de date
     * @param $conn obiect Conectia la baza de date
     * @return array - un array asociativ, care contine toate articolele dib baza de date
     */
    public static function getAll($conn)
    {
        // avem codul sql pentru selectare, pe care-l salvam intr-o variabila
        $sql = "SELECT *
                FROM articole
                ORDER BY data_publicarii;";

        //facem un query in baza de date si salvam rezultatele intr-o variabila
        $results= $conn->query($sql);
        //luam articolele sub forma de array associativ
        // pentru mai multe resurse : https://www.php.net/manual/en/pdostatement.fetch.php
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a page of articles
     * @param object $conn Connection to the database
     * @param integer $limit Number of records to return
     * @param integer $offset Number of records to skio
     * @return array An associative array of the page of article records
     */
    public static function getPage($conn,$limit,$offset, $only_published = false){

        $condition = $only_published ? ' WHERE data_publicarii IS NOT NULL' : '';

        $sql = "SELECT *
                FROM articole
                $condition
                ORDER BY data_publicarii
                LIMIT :limit
                OFFSET :offset";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit',$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);

        $stmt->execute();

        $results= $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;

    }

    /**
     * Metoda care o sa gaseasca un articol dupa ID
     * @param $conn conectia la baza de date
     * @param $id ID-ul articolului
     * @return un obiect al clasei Articol sau null
     */
    public static function getById($conn,$id,$column='*') {

        $sql = "SELECT $column
           FROM articole
           WHERE id= :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Articol');

        if($stmt->execute()) {
            return $stmt->fetch();
        }
    }

    /**
     * Metoda pentru a updata un articol
     * @param obiect $conn conectia la baza de date
     * @return boolean true daca articolul a fost updatat, false daca nu
     */
    public function update($conn) {
        if($this->validate()) {


            $sql = "UPDATE articole 
                SET titlu = :titlu,
                    continut = :continut ,
                    data_publicarii = :data_publicarii
                WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':titlu', $this->titlu, PDO::PARAM_STR);
            $stmt->bindValue(':continut', $this->continut, PDO::PARAM_STR);
            if ($this->data_publicarii == '') {
                $stmt->bindValue(':data_publicarii', $this->data_publicarii, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':data_publicarii', $this->data_publicarii, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } else {
            return false;
        }
    }

    /**
     * Metoda care valideaza proprietatiile articolului
     *
     *
     * @return boolean True daca sunt valide datele introduse, false daca nu
     */

    protected function validate() {

        // we validate the form
        if ($this->titlu == '') {
            $this->errors[]="The title is required";
        }
        if ($this->continut == '') {
            $this->errors[]="The content is required";
        }

        return empty($this->errors);

    }

    /**
     * Metoda pentru a sterge un articol
     * @param object $conn conectiea la baza de date
     * @return boolean True daca articolul a fost sters, fals daca nu
     */
    public function delete($conn) {
        $sql = "DELETE FROM articole 
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function create($conn) {

        if($this->validate()) {


            $sql = "INSERT INTO articole(titlu,continut,data_publicarii)
                    VALUES (:titlu,:continut,:data_publicarii)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':titlu', $this->titlu, PDO::PARAM_STR);
            $stmt->bindValue(':continut', $this->continut, PDO::PARAM_STR);
            if ($this->data_publicarii == '') {
                $stmt->bindValue(':data_publicarii', $this->data_publicarii, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':data_publicarii', $this->data_publicarii, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            };
        } else {
            return false;
        }
    }

    /**
     * Metoda pentru a obtine numarul de articole din baza de date, care au fost publicate
     * @param object $conn conectia la baza de date
     * @return integer numarul total de articole
     */
    public static function getTotal($conn,$only_published = false) {
        $condition = $only_published ? 'WHERE data_publicarii IS NOT NULL' : '';
        $sql = "SELECT COUNT(*) FROM articole $condition";
        $result = $conn->query($sql);
        return $result->fetchColumn();
    }



    public function setImageFile($conn,$filename)
    {
        $sql = "UPDATE articole
                SET foto = :foto
                WHERE id = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':foto', $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        return $stmt->execute();

    }
}