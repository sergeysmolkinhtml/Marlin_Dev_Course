<?php

function getUserByEmail(String $email) : Bool | Array
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $statement = $pdo->prepare('SELECT * FROM module.users WHERE email = :email');
    $statement->execute(['email' => $email]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function setFlashMessage(String $name, String $message) : Void
{
    $_SESSION[$name] = $message;
}

function redirect(String $path) : Void
{
    header("Location: http://marl/Module/Верстка%20проекта/{$path}");
    exit();
}

function createUser(String $email, String $password) : Bool | String
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $sql = "INSERT INTO module.users (email, password) VALUES (:email, :password)";
    $statementAdder = $pdo->prepare($sql);

    $statementAdder->execute(['email' => $_POST['email'], 'password' => password_hash($password, PASSWORD_DEFAULT)]);

    $newUser = $statementAdder->fetch(PDO::FETCH_ASSOC);

    return $pdo->lastInsertId();
}

function displayFlashMessage(String $name) : Void
{
    if(isset($_SESSION[$name])) {
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
        unset($_SESSION[$name]);
    }
}