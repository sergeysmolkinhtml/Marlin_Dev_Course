<?php

session_start();

require_once 'App/Validation.php';
require_once 'App/Input.php';
require_once 'App/Database.php';
require_once 'App/Config.php';
require_once 'App/Token.php';
require_once 'App/Session.php';
require_once 'App/User.php';
require_once 'App/Redirect.php';
require_once 'App/Cookie.php';

//$users = Database::getInstance()->query("SELECT * FROM pureoop.users WHERE username IN (?, ?)" , ['username 1','username2']);

//$users = Database::getInstance()->get('users',['username','=','Usernameka']);

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

$GLOBALS['config'] = [
  'mysql' => [
      'host' => 'localhost',
      'username'  => 'root',
      'password' => '',
      'database' => 'pureoop',
  ],
  'session' => [
        'token_name' => 'token',
        'user_session' => 'user'
  ],
  'cookie' => [
      'cookie_name' => 'hash',
      'cookie_expiry' => 604800,
  ]
];

if(Cookie::exists(Config::get('cookie.cookie_name')) && !Session::exists(Config::get('session.user_session'))) {
    $hash = Cookie::get(Config::get('cookie.cookie_name'));
    $hashCheck = Database::getInstance()->get('user_sessions',['hash','=', $hash]);

    if($hashCheck->getCount()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}

