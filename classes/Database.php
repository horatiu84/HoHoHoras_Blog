<?php

class Database
{
    public function getConnection()
    {
        $db_host='localhost';
        $db_user='root';
        $db_password='';
        $db_name='hohohora';

        $dsn="mysql:host=$db_host;dbname=$db_name;charset=utf8";
        return new PDO($dsn,$db_user,$db_password);
    }
}

// pentru resurse puteti sa va uitati aici : https://www.phptutorial.net/php-pdo/pdo-connecting-to-mysql/