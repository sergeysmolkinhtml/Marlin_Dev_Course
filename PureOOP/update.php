<?php

require_once 'init.php';

$user = new User();
$validate = new Validation();

if(Input::exists()) {
        $validate->check($_POST,[
        'username' => ['required' => true, 'min' => 2]]);
    if(Token::check(Input::get('token'))) {
        if($validate->isPassed()) {
            $user->update(['username' => Input::get('username')]);
            Redirect::to('update.php');
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
        <label for="username"> Username
            <input type="text" name="username" value="<?php echo $user->getData()->username ?> ">
        </label>
    </div>
    <div class="field">
        <button type="submit">Submit</button>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>
