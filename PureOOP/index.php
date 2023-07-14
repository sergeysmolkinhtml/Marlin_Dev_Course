<?php

use App\Database;

require_once 'Database.php';

$users = Database::getInstance()->query("SELECT * FROM pureoop.users WHERE username IN (?, ?)" , ['username 1','username2']);

$users = Database::getInstance()->get('users',['username','=','Usernameka']);

echo $users->first()->username;

//Database::getInstance()->delete('users',['username','=','username 1']);

/*Database::getInstance()->update('users',2,[
    'username' => 'Usernameka',
    'password' => 'pass'
]);*/

/*Database::getInstance()->insert('users',[
    'username' => 'myname',
    'password' => '21412',
]);*/

/*if($users->getErrors()){
    echo 'We have an error';
} else{
    foreach ($users->getResults() as $user){
        echo $user->username . "<br>";
    }
}*/

