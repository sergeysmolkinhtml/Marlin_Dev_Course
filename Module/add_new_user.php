<?php
session_start();

require 'functions.php';


$email = $_POST['email'];
$password = $_POST['password'];

if($_POST) {
    $user = getUserByEmail($email);

    if (!empty($user)) {
        $_SESSION['user_exists'] = 'Емейл занят';
        redirect('create_user.php');
    }

    $userID = createNewUser($_POST);
    uploadAvatar($_FILES['avatar'], $userID);

    $_SESSION['user_created'] = 'Юзер добавлен';
    redirect('users.php');

}