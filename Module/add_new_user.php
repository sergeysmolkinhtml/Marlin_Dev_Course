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

    $userID = createUser($email, $password);
    editUserInfo($_POST['name'],$_POST['job'],$_POST['phone'],$_POST['address'], $userID);
    setStatus($_POST['status'],$userID);
    addSocialLinks($_POST['telegram'],$_POST['instagram'],$_POST['vk'], $userID);
    //uploadAvatar($_FILES['avatar'], $userID);

    $_SESSION['user_created'] = 'Юзер добавлен';
    redirect('users.php');

}