<?php
session_start();

include_once 'OOP_Thought_Process/functions.php';
// подключение к бд
$pdo = new PDO('mysql:host=marl;dbname=users','root', '');
$text = $_POST['mytext'];
// Найти запись
$sql = "SELECT * FROM users.INPUT WHERE text = :text";
$statement = $pdo->prepare($sql);
$statement->execute(['text' => $text]);
$text = $statement->fetch(PDO::FETCH_ASSOC);
// проверка существует ли запись, если да - редирект
if(!empty($text['text'])) {
    $_SESSION['danger'] = "Record already exists";

    header('Location: http://marl/task_11.php');
    exit();
}

// ecли записи нет - добавляем
$statement = $pdo->prepare('INSERT INTO INPUT (text) VALUES (:text) ');
$statement->execute(['text' => $text]);

$_SESSION['success'] = "Record added";

header('Location:  http://marl/task_11.php');