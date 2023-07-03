<?php

class QueryBuilder
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll($tableName) : bool | array
    {
        $statement = $this->pdo->prepare("SELECT * FROM BlogDB.{$tableName}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $tableName, array $data) : void
    {
        $keys = implode(',', array_keys($data));
        $tags = ":" . implode(',', array_keys($data));
        $query = "INSERT INTO BlogDB.{$tableName} ({$keys}) VALUES ({$tags})";
        $statement = $this->pdo->prepare($query);
        $statement->execute($data);
    }

    public function getOne(String $tableName, Int $postId)
    {
        $statement = $this->pdo->prepare("SELECT * FROM BlogDB.{$tableName} WHERE BlogDB.posts.id = :id");
        $statement->execute(['id' => $postId]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}