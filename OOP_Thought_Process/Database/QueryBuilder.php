<?php

class QueryBuilder
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function getAll($tableName) : bool | array
    {
        $statement = $this->pdo->prepare("SELECT * FROM BlogDB.{$tableName}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}