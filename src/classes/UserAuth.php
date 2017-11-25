<?php

class UserAuth
{
    private $sessionManager;
    private $databaseDataManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function userAuthorization(): int
    {
        $newUserLogin =  WebServerRequest::getPostKeyValue('userLogin');
        $newUserPassword =  WebServerRequest::getPostKeyValue('userPassword');
        $statusCode = ResponseStatus::LOGIN_PASSWORD_INCORRECT;
        if ($newUserLogin != null && $newUserPassword != null)
        {
            $passwordHash = PasswordHashCreator::passwordToHash($newUserPassword);
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
            $this->sessionManager->initializeArraySession($currentUserData['id']);
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