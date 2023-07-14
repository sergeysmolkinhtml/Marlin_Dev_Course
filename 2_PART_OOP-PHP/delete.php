<?php
$db = include_once 'Database/Start.php';

$id = $_GET['id'];
$db->delete('posts', $id);

header('Location: http://marl/2_PART_OOP-PHP/index.php');
