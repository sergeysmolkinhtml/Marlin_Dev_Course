<?php


class Database
{
    private static ?Database $instance = null;

    private $results, $count, $query;

    private PDO $pdo;

    private Bool $error = false;

    private function __construct() {
       try {
           $this->pdo = new PDO(
       "mysql:host=".Config::get('mysql.host').
            ";dbname=".Config::get('mysql.database'),
            Config::get('mysql.username'),
            Config::get('mysql.password'));
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

    public function get(String $tableName, Array $where = []) : Bool | Static
    {
        return $this->action('SELECT *', $tableName, $where);
    }

    public function update(String $tableName, Int $id, Array $fields = []) : Bool
    {
        $set = '';
        foreach ($fields as $key=>$field) {
            $set .= "$key = ?,";
        }
        $set = rtrim($set,',');
        $sql = "UPDATE pureoop.$tableName SET $set WHERE id = $id";

        if(!$this->query($sql, $fields)->getErrors()){
            return true;
        }
        return false;
    }

    public function insert(String $tableName, Array $fields = []) : Bool
    {
        $values = '';
        foreach ($fields as $field) {
            $values .= "?,";
        }
        $values = rtrim($values,',');

        $sql = "INSERT INTO pureoop.$tableName (`" . implode('`, `', array_keys($fields)) . "`) VALUES (" . $values .")";

        if(!$this->query($sql, $fields)->getErrors()){
            return true;
        }
        return false;
    }

    public function delete(String $tableName, Array $where = []) : Bool | Static
    {
        return $this->action('DELETE',$tableName, $where);
    }

    public function action(String $action, String $tableName, Array $where = []) : Bool | Static
    {
        $operators = ['=','>','<','>=','=<'];

        if(count($where) === 3) {
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
        }

        if(in_array($operator,$operators)){
            $sql = "$action FROM pureoop.$tableName WHERE $field $operator ?";

            if(!$this->query($sql,[$value])->getErrors()) {
                return $this;
            }
        }
        return false;
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

    public function first()
    {
        return $this->results[0];
    }

}