<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private $results, $count, $query;
    private PDO $pdo;
    private Bool $error = false;

    private function __construct() {
       try {
           $this->pdo = new PDO('mysql:host=marl;dbname=users', 'root', '');
       } catch (PDOException $exception){
           die($exception->getMessage());
       }
   }
   public static function getInstance() : ?Database
   {
       if(self::$instance === null) {
           self::$instance = new Database();
       }
       return self::$instance;
   }

    public function query(String $sql, Array $params = []) : Database
    {
        $this->error = false;
        $this->query = $this->pdo->prepare($sql);

        if(count($params)){
            $i = 1;
            foreach ($params as $param) {
                $this->query->bindValue($i, $param);
                $i++;
            }
        }

        if(! $this->query->execute()){
            $this->error = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }

        return $this;
    }

    public function getErrors() : bool
    {
        return $this->error;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function getCount()
    {
        return $this->count;
    }

   
   
}