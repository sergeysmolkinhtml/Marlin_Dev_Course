<?php

include_once 'functions.php';
$database = include_once 'Database/Start.php';

$posts = $database->getAll('posts');

include_once 'index.view.php';