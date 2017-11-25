<?php

class WebServerRequest
{
    private const DEFAULT_VALUE = null;

    public static function getPostKeyValue(string $key)
    {
        return array_key_exists($key, $_POST) ? $_POST[$key] : self::DEFAULT_VALUE;
    }

    public static function getGetKeyValue(string $key)
    {
        return array_key_exists($key, $_GET) ? $_GET[$key] : self::DEFAULT_VALUE;
    }
}