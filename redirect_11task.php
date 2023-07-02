<?php
session_start();

$pdo = new PDO('mysql:host=marl;dbname=users','root', '');

$text = $_POST['mytext'];

$textExists = "SELECT * FROM users.INPUT WHERE text=:text";
$statement = $pdo->prepare($textExists);
$statement->execute(['text' => $text]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if(!empty($user)) {
    $msg = "Record already exists";
    $_SESSION['msg' ] = $msg;

    header('Location: http://marl/task_11.php');
    exit();
}

$statement = $pdo->prepare('INSERT INTO INPUT (text) VALUES (:text) ');
$statement->execute(['text' => $text]);

header('Location:  http://marl/task_11.php');