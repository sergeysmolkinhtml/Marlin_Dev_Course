<?php
session_start();

require 'functions.php';

$email = $_POST['email'];
if($_POST) {
    $user = getUserByEmail($email);

    if (!empty($user)) {
        $_SESSION['user_exists'] = 'Емейл занят';
        redirect('create_user.php');
    }

    createNewUser($_POST);
    $_SESSION['user_created'] = 'Юзер добавлен';
    redirect('users.php');

}