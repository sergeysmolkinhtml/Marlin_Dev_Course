<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

   private function __construct() {
       try {
           $this->pdo = new PDO('mysql:host=marl;dbname=users', 'root', '');
       } catch (PDOException $exception){
           die($exception->getMessage());
       }
   }
   public static function getInstance() : ?Database
   {
       if(self::$instance === null){
           self::$instance = new Database();
       }
       return self::$instance;
   }
}