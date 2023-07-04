<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = new PDO('mysql:host=marl;dbName=project', 'root','');

$sql = "SELECT * FROM project.users WHERE email=:email";
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if(!empty($user)) {
    $_SESSION['error'] = 'email zanyat';
    header('Location: http://marl/register/create.php');
    exit();
}

$hashed_password = password_hash($password,PASSWORD_DEFAULT);

$sql = "INSERT INTO project.users (email, password) VALUES (:email, :password)";
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email, 'password' => $hashed_password]);