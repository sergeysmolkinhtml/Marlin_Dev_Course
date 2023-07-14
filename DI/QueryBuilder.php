<?php

namespace App\DepInj;

use PDO;

class QueryBuilder
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function select($table) : bool | array
    {
        $stmt = $this->db->query('SELECT * FROM DepInj.$table');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new QueryBuilder(Connection::connect());