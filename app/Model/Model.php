<?php

use Pdo;
class Model
{
    protected static function getConnection()
    {
        $db = new PDO('mysql:host=mariadb; dbname=pokedle', 'root', 'bitnami');
        return $db;
    }
}