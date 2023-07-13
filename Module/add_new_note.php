<?php

include_once 'notes_functions.php';
$userId = $_GET['id'];

if($_POST) {
    $title = $_POST['title'];
    $context = $_POST['context'];
    createNote($title, $context, $userId);
    redirectToProfile();
}