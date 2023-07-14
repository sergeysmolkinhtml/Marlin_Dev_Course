<?php

use App\Database;

require_once 'Database.php';

$users = Database::getInstance()->query("SELECT * FROM pureoop.users WHERE username IN (?, ?)" , ['username 1','username2']);
/*$user1 = Database::getInstance()->get('users',['username','=','username 1']);
$user1 = Database::getInstance()->delete('users',['username','=','username 1']);*/

if($users->getErrors()){
    echo 'We have an error';
} else{
    foreach ($users->getResults() as $user){
        echo $user->username . "<br>";
    }
}

