<?php


namespace App\Helper;


class Env
{
    public static function get($key)
    {
        if(!empty($_ENV[$key])){
            return $_ENV[$key];
        }
        
        return null;
    }
}