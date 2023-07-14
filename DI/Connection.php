<?php

namespace App\DepInj;

use PDO;

class Connection
{
    public static function connect() : PDO
    {
        return new PDO('mysql:host=marl;dbName=DepInj;charset=utf8', 'root', '');
    }

}
