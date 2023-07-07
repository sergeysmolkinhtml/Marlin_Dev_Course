<?php
session_start();
require 'functions.php';

$status = $_POST['status'];

$id = $_GET['id'];
setStatus($status, $id);
header("Location: http://marl/Module/Верстка%20проекта/status.php?id=$id");
