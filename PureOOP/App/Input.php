<?php


class Input
{
    public static function exists($type = 'post') : Bool
    {
        return match ($type) {
            'post' => ! empty($_POST),
            'get' => ! empty($_GET),
            default => false,
        };
    }

    public static function get($item)
    {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } elseif(isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }

}