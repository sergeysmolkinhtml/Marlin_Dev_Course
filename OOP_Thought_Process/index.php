<?php

include_once 'functions.php';
$db = include_once 'Database/Start.php';

$posts = $db->getAll('posts');

include_once 'index.view.php';