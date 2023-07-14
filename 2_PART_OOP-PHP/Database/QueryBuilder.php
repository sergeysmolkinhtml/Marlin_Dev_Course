<?php

include_once '../Module/functions.php';

final class QueryBuilder
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(String $tableName) : Bool | Array
    {
        $statement = $this->pdo->prepare("SELECT * FROM BlogDB.{$tableName}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne(String $tableName, Int $postId) : Array
    {
        $statement = $this->pdo->prepare("SELECT * FROM BlogDB.{$tableName} WHERE BlogDB.posts.id = :id");
        $statement->execute(['id' => $postId]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create(String $tableName, Array $data) : Void
    {
        $keys = implode(',', array_keys($data));
        $tags = ":" . implode(', :', array_keys($data));
        $query = "INSERT INTO BlogDB.{$tableName} ({$keys}) VALUES ({$tags})";
        $statement = $this->pdo->prepare($query);
        $statement->execute($data);
    }

    public function update(String $tableName, Array $data, Int $postId) : Void
    {

        $keys = array_keys($data);

        $query = '';
        foreach ($keys as $key) {
            $query .= $key . '=:' . $key . ',';
        }

        $keys = rtrim($query,',');

        $data['id'] = $postId;

        $statement = $this->pdo->prepare(
            "UPDATE BlogDB.{$tableName} SET {$keys} WHERE BlogDB.posts.id = :id"
        );
        $statement->execute($data);

    }

    public function delete(String $tableName, Int $postId) : Void
    {
        $statement = $this->pdo->prepare("DELETE FROM BlogDB.{$tableName} WHERE BlogDB.posts.id = :id");
        $statement->execute(['id' => $postId]);
    }

}