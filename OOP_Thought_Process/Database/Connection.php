<?php

class Connection
{
    public static function connect() : PDO
    {
        $pdo = new PDO('mysql:host=marl;dbName=BlogDB;charset=utf8', 'root', '');
        return $pdo;
    }
}