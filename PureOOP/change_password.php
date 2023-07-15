<?php
require_once 'init.php';

$user = new User();
$validate = new Validation();

if (Input::exists()) {
    $validate->check($_POST, [
        'currentpassword' => ['required' => true, 'min' => 2],
        'newpassword' => ['required' => true, 'min' => 8],
        'newpasswordconfirm' => ['required' => true, 'min' => 8, 'matches' => 'newpassword']
        ]);
    if (Token::check(Input::get('token'))) {
        if ($validate->isPassed()) {
            if(password_verify(Input::get('currentpassword'), $user->getData()->password)){
                $user->update(['password' => password_hash(Input::get('newpassword'),PASSWORD_DEFAULT)]);
                Session::flash('success','Password has been updated');
                Redirect::to('index.php');
            } else {
                echo 'Invalid current password'; exit();
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
        <label for="username"> Current password
            <input type="text" name="currentpassword">
        </label>
    </div>
    <div class="field">
        <label for="username"> New password
            <input type="text" name="newpassword"">
        </label>
    </div>
    <div class="field">
        <label for="username"> Confirm New password
            <input type="text" name="newpasswordconfirm">
        </label>
    </div>
    <div class="field">
        <button type="submit">Submit</button>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>
