<?php
session_start();

require_once 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$user = getUserByEmail($email);

if(!empty($user)) {
    setFlashMessage('user_exists', 'Адреcс занят другим пользователем');
    redirect('page_register.php');
}

createUser($email,$password);

setFlashMessage('user_created', 'Регистрация успешна');
redirect('page_login.php');

/*$pdo = new PDO('mysql:host=marl;dbname=module','root', '');

if($_POST) {
    $statement = $pdo->prepare('SELECT * FROM module.users WHERE email = :email');
    $email = $_POST['email'];
    $statement->execute(['email' => $email]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if(!empty($user['email'])) {
        $_SESSION['user_exists'] = 'Log: Юзер с таким емейлом уже существует';
        header('Location: http://marl/Module/Верстка%20проекта/page_register.php');
        exit();
    }

}


$sql = "INSERT INTO module.users (email, password) VALUES (:email, :password)";
$statementAdd = $pdo->prepare($sql);
$password = $_POST['password'];
$statementAdd->execute(['email' => $_POST['email'], 'password' => password_hash($password, PASSWORD_DEFAULT)]);
$newUser = $statementAdd->fetch(PDO::FETCH_ASSOC);

$_SESSION['user_created'] = 'Log: Юзер успешно зарегестрирован';

header('Location: http://marl/Module/Верстка%20проекта/page_login.php');*/
