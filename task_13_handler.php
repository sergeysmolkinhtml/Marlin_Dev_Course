<?php
session_start();

$text = $_POST['inputext'];

$_SESSION['text'] = $text;

header('Location: http://marl/task_13.php');