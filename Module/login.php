<?php
session_start();

require_once '../OOP_Thought_Process/functions.php';
require_once 'functions.php';


function Login() : Bool
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($_POST) {
        $pdo = new PDO('mysql:host=marl;dbname=module', 'root', '');
        $userByEmail = $pdo->prepare('SELECT * FROM module.users WHERE email = :email');
        $userByEmail->execute(['email' => $email]);
        $user = $userByEmail->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['wrong_email'] = 'Неправильный емейл';
            return false;
        }

        $hashedPassword = $user['password'];

        if (!password_verify($password, $hashedPassword)) {
            $_SESSION['wrong_password'] = 'Неправильный пароль';
            return false;
        }
    }

    return true;
}
if(Login())
    redirect('users.html');
else
    redirect('page_login.php');









