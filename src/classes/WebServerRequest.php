<?php

class WebServerRequest
{
    public function postKeyIsExists(string $key): bool
    {
        return array_key_exists($key, $_POST) ? true : false;
    }

    public function getPostKeyValue(string $key)
    {
        return $_POST[$key];
    }

    public function getKeyIsExists(string $key): bool
    {
        return array_key_exists($key, $_GET) ? true : false;
    }

    public function getGetKeyValue(string $key)
    {
        return $_GET[$key];
    }
}