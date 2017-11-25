<?php

class PasswordHashCreator
{
    public static function passwordToHash(string $userPassword): string
    {
        return md5($userPassword);
    }
}