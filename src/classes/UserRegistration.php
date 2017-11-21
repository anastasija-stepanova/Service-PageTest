<?php

class UserRegistration
{
    private $dataValidator;
    private $databaseDataManager;
    private $sessionClient;

    public function __construct($sessionClient, $databaseDataManager)
    {
        $this->sessionClient = $sessionClient;
        $this->databaseDataManager = $databaseDataManager;
        $this->dataValidator = new DataValidator();
    }

    public function getStatusLogin(string $userLogin): int
    {
        $validatedLogin = $this->checkValidationError($userLogin, 'validateLogin');
        if ($validatedLogin)
        {
            return $this->databaseDataManager->isExistsUser($userLogin) ? ResponseStatus::USER_EXISTS : ResponseStatus::SUCCESS_STATUS;
        }
        else
        {
            return ResponseStatus::INVALID_LOGIN;
        }
    }

    public function getStatusPassword(string $userPassword, string $userPasswordChecked): int
    {
        $validatedPassword = $this->checkValidationError($userPassword, 'validatePassword');
        if ($validatedPassword)
        {
            return $userPassword != $userPasswordChecked ? ResponseStatus::PASSWORDS_NOT_MATCH : ResponseStatus::SUCCESS_STATUS;
        }
        else
        {
            return ResponseStatus::INVALID_PASSWORD;
        }
    }

    public function getStatusApiKey(string $apiKey): int
    {
        $validatedApiKey = $this-> checkValidationError($apiKey, 'validateApiKey');
        if ($validatedApiKey)
        {
            return $this->databaseDataManager->isExistsApiKey($apiKey) ? ResponseStatus::API_KEY_EXISTS : ResponseStatus::SUCCESS_STATUS;
        }
        else
        {
            return ResponseStatus::INVALID_API_KEY;
        }
    }

    private function checkValidationError(string $userInfo, $methodName): bool
    {
        return $this->dataValidator->$methodName($userInfo) ? true : false;
    }
}