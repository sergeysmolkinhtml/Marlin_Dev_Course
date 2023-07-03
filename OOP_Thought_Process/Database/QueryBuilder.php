<?php

class QueryBuilder
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function getAll() : bool | array
    {
        $statement = $this->pdo->prepare('SELECT * FROM BlogDB.posts');
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }

}