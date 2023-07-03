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

    function create(string $tableName, array $data) : void
    {
        $keys = implode(',', array_keys($data));
        $tags = ":" . implode(',', array_keys($data));
        $query = "INSERT INTO BlogDB.{$tableName} ({$keys}) VALUES ({$tags})";
        $statement = $this->pdo->prepare($query);
        $statement->execute($data);
        dd($statement);
    }
}