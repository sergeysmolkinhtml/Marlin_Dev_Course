<?php

use App\QueryBuilder;

$db = new QueryBuilder();
$db->insert('posts',['title' => '12321']);
