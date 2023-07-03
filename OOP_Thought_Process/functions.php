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

function getAllPosts() : bool | array
{
    $pdo = new PDO('mysql:host=marl;dbName=BlogDB;charset=utf8', 'root', '');
    $statement = $pdo->prepare('SELECT * FROM BlogDB.posts');
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
}
