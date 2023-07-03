<?php

include_once 'functions.php';
include_once 'Database/QueryBuilder.php';

$pdo = connectToDatabase();
$db = new QueryBuilder($pdo);
$posts = $db->getAll();



include_once 'index.view.php';