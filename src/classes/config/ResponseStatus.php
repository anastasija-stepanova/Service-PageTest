<?php

class ResponseStatus
{
    const INVALID_URL = 0;
    const SUCCESS_STATUS = 1;
    const VALID_URL = 2;
    const INVALID_DOMAIN = 3;
    const VALID_DOMAIN = 4;
    const REGISTRATION_ERROR = 5;
    const USER_EXISTS = 6;
    const PASSWORDS_NOT_MATCH = 7;
    const LOGIN_PASSWORD_INCORRECT = 8;
    const API_KEY_EXISTS = 9;
    const INVALID_LOGIN = 10;
    const INVALID_PASSWORD = 11;
    const INVALID_API_KEY = 12;
}