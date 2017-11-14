<?php

class AuthClient
{
    public function __construct($sessionClient)
    {
        $this->sessionClient = $sessionClient;
        $this->webServerRequest = new WebServerRequest();
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function initializeUserData(): void
    {
        $isExistsUserLogin =  $this->webServerRequest->postKeyExists('userLogin');
        if ($isExistsUserLogin)
        {
            $newUserLogin = $this->webServerRequest->getPostKeyValue('userLogin');
            $isExistsUserPassword =  $this->webServerRequest->postKeyExists('userPassword');

            if ($isExistsUserPassword)
            {
                $newUserPassword = $this->webServerRequest->getPostKeyValue('userPassword');

                $passwordHash = $this->sessionClient->passwordToHash($newUserPassword);
                $currentUserData = $this->databaseDataManager->getUserData($newUserLogin, $passwordHash);
                if (!$currentUserData)
                {
                    echo RequireStatus::LOGIN_PASSWORD_INCORRECT;
                }
                else
                {
                    $this->loginUser($currentUserData, $newUserLogin, $passwordHash);
                }
            }
        }
    }

    private function loginUser(array $currentUserData, string $newUserLogin, string $passwordHash): void
    {
        if ($currentUserData && array_key_exists(0, $currentUserData))
        {
            $this->sessionClient->initializeArraySession($currentUserData[0]['id']);
            if (array_key_exists(0, $currentUserData))
            {
                $currentUserLogin = $currentUserData[0]['login'];
                $currentUserPassword = $currentUserData[0]['password'];
                if ($newUserLogin == $currentUserLogin && $passwordHash == $currentUserPassword)
                {
                    echo RequireStatus::SUCCESS_STATUS;
                }
                else
                {
                    echo RequireStatus::LOGIN_PASSWORD_INCORRECT;
                }
            }
        }
    }
}