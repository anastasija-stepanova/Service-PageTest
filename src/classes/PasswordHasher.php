<?php

class PasswordHasher
{
    public function passwordToHash(string $userPassword): string
    {
        return md5($userPassword);
    }
}