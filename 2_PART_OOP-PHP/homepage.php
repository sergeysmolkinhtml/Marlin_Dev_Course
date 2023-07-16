<?php

require '../vendor/autoload.php';

use Aura\SqlQuery\QueryFactory;

$database = include_once 'Database/Start.php';

$posts = $database->getAll('posts');

include_once 'index.view.php';