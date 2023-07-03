<?php

class Connection
{
    public static function connect($config) : PDO
    {
        return new PDO("{$config['connection']};
                            dbName={$config['database']};
                            charset={$config['charset']}",
                            $config['username'],
                            $config['password']);

    }
}