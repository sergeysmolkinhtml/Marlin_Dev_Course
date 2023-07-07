<?php
session_start();

require 'functions.php';
$id = $_SESSION['user']['id'];

uploadAvatar($_FILES['avatar'], $id);
$_SESSION['success'] = 'Профиль успещно обновлен!!!';
header("Location: http://marl/Module/Верстка%20проекта/media.php");
