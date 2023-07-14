<?php

include_once './Database/QueryBuilder.php';
include_once './Database/Connection.php';
$config = include_once './config.php';

return new QueryBuilder(Connection::connect(
    $config['mysql']
));