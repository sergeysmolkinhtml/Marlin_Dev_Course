<?php

namespace App;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private PDO $pdo;
    private QueryFactory $queryFactory;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=mysql;dbname=DepInj;charset=utf8', 'root', '');
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getAll($table) : array | bool
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])->from($table);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function insert($table, $data) : void
    {
        $insert = $select = $this->queryFactory->newInsert();

        $insert->into($table)
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());

    }

    public function update($table, $data,$id) : void
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)
            ->where("id = :id")
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

}