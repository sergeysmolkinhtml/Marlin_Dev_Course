<?php

require_once 'init.php';

if(Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validation();
        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
                'unique' => 'users',
            ],
            'email' => [
                'required' => true,
                'email' => true,
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


        if ($validation->isPassed()) {
            $user = new User();
            $user->create([
                'username' => Input::get('username'),
                'password' => password_hash(Input::get('password'),PASSWORD_DEFAULT),
                'email'    => Input::get('email'),
            ]);
            Session::flash('success','register success');
            Redirect::to('init.php');
        } else {
            foreach ($validation->getErrors() as $error) {
                echo $error . "<br>";
            }
        }
    }
}

?>

<form action="" method="post">
    <?php echo Session::flash('success'); ?>
    <div class="field">
        <label for="username">Username
            <input type="text" name="username" value="<?php echo Input::get('username') ?>">
        </label>
    </div>
    <div class="field">
        <label for="email">Email
            <input type="text" name="email" value="<?php echo Input::get('email') ?>">
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
    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <div class="field">
        <button type="submit">Submit</button>
    </div>
</form>


