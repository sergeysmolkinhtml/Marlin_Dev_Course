<?php
session_start();

require_once 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$user = getUserByEmail($email);

if(!empty($user)) {
    setFlashMessage('user_exists', 'Адреc занят другим пользователем');
    redirect('page_register.php');
}

createUser($email,$password);

setFlashMessage('user_created', 'Регистрация успешна');
redirect('page_login.php');

