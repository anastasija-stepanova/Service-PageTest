<?php

class RegistrationClient
{
    public $userLogin;
    public $userPassword;
    public $apiKey;
    public $webServerRequest;

    public function __construct($sessionClient)
    {
        $this->sessionClient = $sessionClient;
        $this->webServerRequest = new WebServerRequest();
        $this->dataValidator = new DataValidator();
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function checkUserLogin(): bool
    {
        $this->checkRegistrationError('userLogin');

        $this->userLogin = $this->webServerRequest->getPostKeyValue('userLogin');
        $this->checkValidationError($this->userLogin, 'validateLogin');

        if ($this->databaseDataManager->isExistsUser($this->userLogin))
        {
            echo RequireStatus::USER_EXISTS;
            return false;
        }

        return true;
    }

    public function checkUserPassword(): bool
    {
        $this->checkRegistrationError('userPassword');
        $this->checkRegistrationError('userPasswordChecked');

        $this->userPassword = $this->webServerRequest->getPostKeyValue('userPassword');
        $userPasswordChecked = $this->webServerRequest->getPostKeyValue('userPasswordChecked');
        if ($this->checkValidationError($this->userPassword, 'validatePassword') && $this->checkValidationError($userPasswordChecked, 'validatePassword'))
        {
            if ($this->userPassword != $userPasswordChecked)
            {
                echo RequireStatus::PASSWORDS_NOT_MATCH;
            }
        }

        return true;
    }

    public function checkApiKey(): bool
    {
        $this->checkRegistrationError('apiKey');
        $this->apiKey = $this->webServerRequest->getPostKeyValue('apiKey');
        $this->checkValidationError($this->apiKey, 'validateApiKey');
        return true;
    }

    private function keyExists(string $key): bool
    {
        return $this->webServerRequest->postKeyExists($key) ? true : false;
    }

    private function checkRegistrationError(string $key): bool
    {
        if (!$this->keyExists($key))
        {
            echo RequireStatus::REGISTRATION_ERROR;
            return false;
        }
        return true;
    }

    private function checkValidationError(string $userInfo, $methodName): bool
    {
        return ($this->dataValidator->$methodName($userInfo)) ? true : false;
    }
}