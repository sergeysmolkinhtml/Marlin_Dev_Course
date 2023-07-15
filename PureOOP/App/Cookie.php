<?php

class Cookie
{
    public static function exists($name) : Bool
    {
        return isset($_COOKIE[$name]);
    }

    public static function get($name)
    {
        return $_COOKIE[$name];
    }

    public static function put($name,$value,$expiry) : Bool
    {
        if(setcookie($name, $value, time() + $expiry)) {
            return true;
        }
        return false;
    }

    public static function delete($name) : void
    {
        self::put($name,'', time() - 1);
    }
}