<?php

class DataValidator
{
    const REGULAR_EXPRESSION = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

    public static function validateUrl($url)
    {
        return preg_match(self::REGULAR_EXPRESSION, $url);
    }
}