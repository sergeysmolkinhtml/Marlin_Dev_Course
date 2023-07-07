<?php
session_start();
include "functions.php";

$id = $_GET['id'];

delete($id);

header("Location: http://marl/Module/Верстка%20проекта/users.php");

