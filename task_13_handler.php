<?php
session_start();


if ($_POST) {
    $text = $_POST['inputext'];
    $_SESSION['msg'] = $text;
}

header('Location: http://marl/task_13.php');




