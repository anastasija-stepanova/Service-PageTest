<?php

class UserDomainEditor
{
    private $databaseDataManager;
    private $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function saveNewDomain(string $json)
    {
        $jsonDecoded = json_decode($json, true);
        $lastError = json_last_error();

        if ($lastError === JSON_ERROR_NONE)
        {
            $newDomain = $jsonDecoded['value'];

            $domainExists = $this->databaseDataManager->getDomainId($newDomain);

            if (!$domainExists && $this->validateDomain($newDomain) == ResponseStatus::VALID_DOMAIN)
            {
                $this->databaseDataManager->saveDomain($newDomain);

                if (array_key_exists('id', $domainExists))
                {
                    $userId = $this->sessionManager->getUserId();
                    $this->databaseDataManager->saveUserDomain($userId, $domainExists['id']);
                    return $newDomain;
                }
            }
        }
        return $lastError;
    }

    public function editExistingDomain(string $json)
    {
        $jsonDecoded = json_decode($json, true);
        $lastError = json_last_error();

        if ($lastError === JSON_ERROR_NONE)
        {
            $currentDomain = $jsonDecoded['currentDomain'];
            $newDomain = $jsonDecoded['newDomain'];

            $editableDomainId = $this->databaseDataManager->getDomainId($currentDomain);

            if (array_key_exists('id', $editableDomainId) && $this->validateDomain($newDomain) == ResponseStatus::VALID_DOMAIN)
            {
                $this->databaseDataManager->editDomain($editableDomainId['id'], $newDomain);
            }
        }
        return $lastError;
    }

    private function validateDomain(string $newDomain): int
    {
        $isDomain = DataValidator::validateDomain($newDomain);
        return $isDomain ? ResponseStatus::VALID_DOMAIN : ResponseStatus::INVALID_DOMAIN;
    }
}