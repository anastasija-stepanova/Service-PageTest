<?php

class UserDomainEditor
{
    private $databaseDataManager;
    private $sessionManager;
    private const DEFAULT_VALUE = -1;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function saveNewDomain(string $newDomain): int
    {
        if (DataValidator::validateDomain($newDomain))
        {
            $this->saveValidDomain($newDomain);
            return ResponseStatus::SUCCESS_STATUS;
        }
        else
        {
            return ResponseStatus::INVALID_DOMAIN;
        }
    }

    public function editExistingDomain(string $currentDomain, string $newDomain): int
    {
        $editableDomainId = $this->databaseDataManager->getDomainId($currentDomain);
        if (DataValidator::validateDomain($newDomain))
        {
            $this->databaseDataManager->editDomain($editableDomainId, $newDomain);
            return ResponseStatus::SUCCESS_STATUS;
        }
        else
        {
            return ResponseStatus::INVALID_DOMAIN;
        }
    }

    private function saveValidDomain(string $newDomain): void
    {
        $domainId = $this->databaseDataManager->getDomainId($newDomain);
        if ($domainId == self::DEFAULT_VALUE)
        {
            $this->databaseDataManager->saveDomain($newDomain);
            $newDomainId = $this->databaseDataManager->getDomainId($newDomain);
            $userId = $this->sessionManager->getUserId();
            $this->databaseDataManager->saveUserDomain($userId, $newDomainId);
        }
        else
        {
            $userId = $this->sessionManager->getUserId();
            $this->databaseDataManager->saveUserDomain($userId, $domainId);
        }
    }
}