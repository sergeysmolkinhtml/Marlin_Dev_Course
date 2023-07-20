<?php

namespace App\Models;

use Aura\SqlQuery\QueryFactory;
use PDO;

class Query
{
    private PDO $db;
    private QueryFactory $queryFactory;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function fetchFrom($tableName, Array $clauses = []) : bool | array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])->from($tableName);

        $sth = $this->db->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(String $tableName, Int $id, Array $data) : void
    {
        $update = $this->queryFactory->newUpdate();

        //$cols = implode(',', array_keys($data));
        $binds = [];

        foreach ($data as $key => $value) {
            $binds[$key] = $value;
        }

        $update->table($tableName)
            ->cols($binds)
            ->where("id = :id", ['id' => $id]);

        $sth = $this->db->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }




}