<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn]
function dd($data) : void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function connectToDatabase() : PDO
{
    $pdo = new PDO('mysql:host=marl;dbName=BlogDB;charset=utf8', 'root', '');
    return $pdo;
}


