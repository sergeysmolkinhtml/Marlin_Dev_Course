<?php

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = new PDO('mysql:host=marl;dbName=project', 'root','');

$sql = "SELECT * FROM project.users WHERE email=:email";
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if(empty($user)) {
    $_SESSION['error'] = 'Неверный логин или пароль';
    header('Location: http://marl/register/auth_form.php');
    exit();
}

if(!password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Неверный логин или пароль';
    header('Location: http://marl/register/auth_form.php');
    exit();
}
$_SESSION['user'] = ['email' => $user['email'],'id' => $user['id']];

header('Location: http://marl/register/index.php');
exit();
