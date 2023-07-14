<?php

include_once 'functions.php';
$database = include_once 'Database/Start.php';
// получить id с глоб масива, в который id пришел с базы данных
$id = $_GET['id'];
$post = $database->getOne('posts', $id);
?>

<h1><?php echo $post['title']?></h1>
