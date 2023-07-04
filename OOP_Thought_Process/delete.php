<?php
$db = include_once 'Database/Start.php';

$id = $_GET['id'];
$db->delete('posts', $id);

header('Location: http://marl/OOP_Thought_Process/index.php');
