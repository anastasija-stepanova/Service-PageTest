<?php

class DataValidator
{
    const REGULAR_EXPRESSION_DOMAIN = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    const REGULAR_EXPRESSION_PART_OF_URL = '/\/|^\/[a-z0-9-]+$/';
    const REGULAR_EXPRESSION_LOGIN = '/[a-z][a-z0-9-_\.]{5,20}$/';
    const REGULAR_EXPRESSION_PASSWORD = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/';
    const REGULAR_EXPRESSION_API_KEY = '/^[A-Z].[a-zA-Z0-9]+$/';

    public static function validateDomain(string $domain): bool
    {
        return preg_match(self::REGULAR_EXPRESSION_DOMAIN, $domain);
    }

    public static function validateUrl(string $url): bool
    {
        return preg_match(self::REGULAR_EXPRESSION_PART_OF_URL, $url);
    }

    public static function validateLogin(string $login): bool
    {
        return preg_match(self::REGULAR_EXPRESSION_LOGIN, $login);
    }

    public static function validatePassword(string $password): bool
    {
        return preg_match(self::REGULAR_EXPRESSION_PASSWORD, $password);
    }

    public static function validateApiKey(string $apiKey): bool
    {
        return preg_match(self::REGULAR_EXPRESSION_API_KEY, $apiKey);
    }
}