<?php

require_once 'Validation.php';
require_once 'Input.php';
require_once 'Database.php';
require_once 'Config.php';

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
];
// usage
if(Input::exists()) {
    $validate = new Validation();
    $validation = $validate->check($_POST,[
        'username' => [
          'required' => true,
          'min' => 2,
          'max' => 15,
          'unique' => 'users',
        ],
        'password' => [
            'required' => true,
            'min' => 3,
        ],
        'password_again' => [
            'required' => true,
            'matches' => 'password',
        ]
    ]);

    if($validation->isPassed()) {
        echo 'Passed';
    } else{
        foreach ($validation->getErrors() as $error) {
            echo $error . "<br>";
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username
            <input type="text" name="username" value="<?php echo Input::get('username') ?>">
        </label>
    </div>
    <div class="field">
        <label for="password">Password
            <input type="text" name="password">
        </label>
    </div>
    <div class="field">
        <label for="password_confirm">Password confirm
            <input type="text" name="password_again">
        </label>
    </div>
    <div class="field">
        <button type="submit">Submit</button>
    </div>
</form>


