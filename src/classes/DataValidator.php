<?php

class DataValidator
{
    const REGULAR_EXPRESSION_DOMAIN = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    const REGULAR_EXPRESSION_URL = ' /^\/[a-z0-9-]+$/';

    public static function validateDomain(string $domain): bool
    {
        return preg_match(self::REGULAR_EXPRESSION_DOMAIN, $domain);
    }

    public static function validateUrl(string $url): bool
    {
        return preg_match(self::REGULAR_EXPRESSION_URL, $url);
    }
}