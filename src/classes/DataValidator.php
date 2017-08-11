<?php

class DataValidator
{
    const REGULAR_EXPRESSION_DOMAIN = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    const REGULAR_EXPRESSION_URL = ' /^\/[a-z0-9-]+$/';

    public static function validateDomain($domain)
    {
        return preg_match(self::REGULAR_EXPRESSION_DOMAIN, $domain);
    }

    public static function validateUrl($url)
    {
        return preg_match(self::REGULAR_EXPRESSION_URL, $url);
    }
}