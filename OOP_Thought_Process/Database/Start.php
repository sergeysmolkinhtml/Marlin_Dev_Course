<?php

include_once './Database/QueryBuilder.php';
include_once './Database/Connection.php';


return new QueryBuilder(Connection::connect());