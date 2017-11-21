<?php

class UserDomainEditor
{
    private $databaseDataManager;
    private $sessionClient;

    public function __construct($sessionClient)
    {
        $this->sessionClient = $sessionClient;
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function saveNewDomain(string $json)
    {
        $jsonDecoded = json_decode($json, true);
        $lastError = json_last_error();

        if ($lastError === JSON_ERROR_NONE)
        {
            $newDomain = $jsonDecoded['value'];

            echo $this->validateDomain($newDomain);

            $domainExists = $this->databaseDataManager->getDomainId($newDomain);

            if (!$domainExists)
            {
                $this->databaseDataManager->saveDomain($newDomain);

                if (array_key_exists('id', $domainExists))
                {
                    $userId = $this->sessionClient->getUserId();
                    $this->databaseDataManager->saveUserDomain($userId, $domainExists['id']);
                    echo $newDomain;
                }
            }
        }
        else
        {
            echo $lastError;
        }
    }

    public function editExistingDomain(string $json)
    {
        $jsonDecoded = json_decode($json, true);
        $lastError = json_last_error();

        if ($lastError === JSON_ERROR_NONE)
        {
            $currentDomain = $jsonDecoded['currentDomain'];
            $newDomain = $jsonDecoded['newDomain'];

            $this->validateDomain($newDomain);

            $editableDomainId = $this->databaseDataManager->getDomainId($currentDomain);


            if (array_key_exists('id', $editableDomainId))
            {
                $this->databaseDataManager->editDomain($editableDomainId['id'], $newDomain);
            }
        }
        else
        {
            echo $lastError;
        }
    }

    private function validateDomain(string $newDomain): int
    {
        $dataValidator = new DataValidator();
        $isDomain = $dataValidator->validateDomain($newDomain);
        return $isDomain ? ResponseStatus::VALID_DOMAIN : ResponseStatus::INVALID_DOMAIN;
    }
}