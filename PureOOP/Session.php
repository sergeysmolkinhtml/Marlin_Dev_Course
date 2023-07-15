<?php

class Session
{
    public static function put($name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    public static function exists($name) : Bool
    {
        return isset($_SESSION[$name]);
    }

    public static function delete($name) : Void
    {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function get($name)
    {
        return $_SESSION[$name];
    }

}