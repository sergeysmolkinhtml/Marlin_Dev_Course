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

function getAllUsers() : Array | Bool
{
    $pdo = new PDO('mysql:host=marl;dbname=module', 'root', '');
    $stmt = $pdo->prepare('SELECT * FROM module.users');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function isNotLoggedIn() : Bool
{
    return !isLoggedIn();
}

function isLoggedIn() : Bool
{
    if(isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

function isAdmin($user) : bool
{
    return $user['role'] === 'admin';
}

function getCurrentUser()
{
    if(isLoggedIn()) {
        return $_SESSION['user'];
    }
   return false;
}

function isEqual($user, $currentUser) : Bool
{
    if($user['id'] == $currentUser['id']){
         return true;
    }
    return false;
}

function createNewUser(Array $data) : Bool
{
    $pdo = new PDO('mysql:host=marl;dbname=module','root', '');
    $sql = "INSERT INTO module.users (name, job, phone, address, email, password, status, avatar, vk, telegram, instagram)
    VALUES (:name,:job,:phone,:address,:email,:password,:status,:avatar,:vk,:telegram,:instagram)";
    $statementAdder = $pdo->prepare($sql);
    $user = $statementAdder->execute($data);
    return $user;
}