<?php

session_start();

require 'functions.php';
$pdo = new PDO('mysql:host=marl;dbname=module','root', '');

if($_POST) {
    // если юзер не ввел емейл , будет старый
    $id = $_GET['id'];

    $emailOld = "SELECT * FROM module.users WHERE id = $id";
    $statement = $pdo->prepare($emailOld);
    $statement->execute();
    $emailOld = $statement->fetch(PDO::FETCH_ASSOC);

    $password = $_POST['password'];
    $password_confirmation = $_POST['confirm_password'];

    $email = $_POST['email'];

    if(rtrim($emailOld['email']) === rtrim($email)) {
        $_SESSION['error_email'] = 'Такой адррес уже существует';
        header("Location: http://marl/Module/Верстка%20проекта/security.php?id=$id");
        exit();
    }

    if($password !== $password_confirmation) {
        $_SESSION['error_confirm'] = 'Пароли не совпадают';
        header("Location: http://marl/Module/Верстка%20проекта/security.php?id=$id");
        exit();
    }


    $statement = $pdo->prepare(
        "UPDATE module.users SET email = :email, password = :password WHERE id=$id"
    );

    $statement->execute([
        'email' => $email,
        'password' => password_hash($password,PASSWORD_DEFAULT)
    ]);

    $updUser = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user_updated'] = 'Юзер обновлён';
    header("Location: http://marl/Module/Верстка%20проекта/security.php?id=$id");


}
