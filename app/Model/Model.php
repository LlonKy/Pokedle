<?php

use Pdo;
class Model
{
    public static function getConnection(){
        $db = new PDO('mysql:host=mariadb; dbname=pokedle', 'root', 'bitnami');
        return $db;
    }
}