<?php
require_once 'init.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))) {
        $validate = new Validation();

        $validate->check($_POST,[
            'email' => ['required' => true, 'email' => true],
            'password' => ['required' => true],
        ]);

        if($validate->isPassed()) {
            $user = new User();
            $remember = (Input::get('remember')) === 'on' ? true : false;
            $login = $user->login(Input::get('email'), Input::get('password'), $remember);

            if($login) {
                echo 'login successful';
                Redirect::to('index.php');
            } else {
                echo 'login failed';
            }
        } else {
            foreach ($validate->getErrors() as $error) {
                echo $error . "<br>";
            }
        }
    }
}


?>


<form action="" method="post">
    <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo Input::get('email')?>">
    </div>
    <div class="field">
        <label for="email">Password</label>
        <input type="text" name="password" value="<?php echo Input::get('password')?>">
    </div>
    <div class="field">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember"> Remember me</label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    <div class="field">
        <button type="submit">Submit</button>
    </div>

</form>