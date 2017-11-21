<?php

class UserAuth
{
    private $sessionClient;
    private $webServerRequest;
    private $databaseDataManager;
    private $passwordHasher;

    public function __construct($sessionClient)
    {
        $this->sessionClient = $sessionClient;
        $this->webServerRequest = new WebServerRequest();
        $this->databaseDataManager = new DatabaseDataManager();
        $this->passwordHasher = new PasswordHasher();
    }

    public function userAuthorization(): int
    {
        $isExistsUserLogin =  $this->webServerRequest->postKeyExists('userLogin');
        $isExistsUserPassword =  $this->webServerRequest->postKeyExists('userPassword');
        $statusCode = ResponseStatus::LOGIN_PASSWORD_INCORRECT;
        if ($isExistsUserLogin && $isExistsUserPassword)
        {
            $newUserLogin = $this->webServerRequest->getPostKeyValue('userLogin');
            $newUserPassword = $this->webServerRequest->getPostKeyValue('userPassword');
            $passwordHash = $this->passwordHasher->passwordToHash($newUserPassword);
            $currentUserData = $this->databaseDataManager->getUserData($newUserLogin, $passwordHash);
            $statusCode = $this->getStatus($currentUserData, $newUserLogin, $passwordHash);
        }
        return $statusCode;
    }

    private function loginUser(array $currentUserData, string $newUserLogin, string $passwordHash): int
    {
        $statusCode = ResponseStatus::LOGIN_PASSWORD_INCORRECT;
        if ($currentUserData)
        {
            $this->sessionClient->initializeArraySession($currentUserData['id']);
            $currentUserLogin = $currentUserData['login'];
            $currentUserPassword = $currentUserData['password'];
            $statusCode = $this->getStatusLogin($currentUserLogin, $currentUserPassword, $newUserLogin, $passwordHash);
        }
        return $statusCode;
    }

    private function getStatusLogin(string $currentUserLogin, string $currentUserPassword, string $newUserLogin, string $passwordHash): int
    {
        return $newUserLogin == $currentUserLogin && $passwordHash == $currentUserPassword ? ResponseStatus::SUCCESS_STATUS : ResponseStatus::LOGIN_PASSWORD_INCORRECT;
    }

    private function getStatus(array $currentUserData, string $newUserLogin, string $passwordHash): int
    {
        $statusCode = ResponseStatus::LOGIN_PASSWORD_INCORRECT;
        if($currentUserData)
        {
            $this->loginUser($currentUserData, $newUserLogin, $passwordHash);
            $statusCode = ResponseStatus::SUCCESS_STATUS;
        }
        return $statusCode;
    }
}