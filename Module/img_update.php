<?php
session_start();

require 'functions.php';
$id = $_GET['id'];

uploadAvatar($_FILES['avatar'], $id);
$_SESSION['success_img'] = 'Профиль успещно обновлен!!!';
header("Location: http://marl/Module/Верстка%20проекта/media.php?id=$id");
