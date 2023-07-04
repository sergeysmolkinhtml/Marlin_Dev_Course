<?php

include_once 'functions.php';
$db = include_once 'Database/Start.php';

$id = $_GET['id'];
$db->update('posts', $_POST, $id);

header("Location: http://marl/OOP_Thought_Process/edit.php?id=$id");