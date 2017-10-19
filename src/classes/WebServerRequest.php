<?php

class WebServerRequest
{
    public function postKeyIsExists($key)
    {
        return array_key_exists($key, $_POST) ? true : false;
    }

    public function getPostKeyValue($key)
    {
        return $_POST[$key];
    }

    public function getKeyIsExists($key)
    {
        return array_key_exists($key, $_GET) ? true : false;
    }

    public function getGetKeyValue($key)
    {
        return $_GET[$key];
    }
}