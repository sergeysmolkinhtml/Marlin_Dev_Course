<?php

include_once 'functions.php';
$db = include_once 'Database/Start.php';

/*$query = "INSERT INTO BlogDB.posts (title) VALUES ('tITLE 3')";*/

$db->create('posts',[
    'title' => $_POST['title'],
]);

header('Location: http://marl/2_PART_OOP-PHP/index.php');
