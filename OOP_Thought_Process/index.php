<?php

include_once 'functions.php';
$db = include_once 'Database/Start.php';

$posts = $db->getAll();

include_once 'index.view.php';