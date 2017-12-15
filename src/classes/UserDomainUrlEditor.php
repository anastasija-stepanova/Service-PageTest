<?php

class UserDomainUrlEditor
{
    private $databaseDataManager;
    private $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function saveNewUrl(string $domain, string $url): int
    {
        if (DataValidator::validateUrl($url))
        {
            $domainId = $this->databaseDataManager->getUserDomain($domain);

            if (!$this->databaseDataManager->doesUserUrlExists($domainId, $url))
            {
                $this->databaseDataManager->saveUserDomainUrl($domainId, $url);
                return ResponseStatus::SUCCESS_STATUS;
            }
            else
            {
                return ResponseStatus::URL_EXISTS;
            }
        }
        else
        {
            return ResponseStatus::INVALID_URL;
        }
    }

    public function deleteUrl(string $domain, array $urls): int
    {
        $domainId = $this->databaseDataManager->getUserDomain($domain);

        foreach ($urls as $url)
        {
            $this->databaseDataManager->deleteUrl($domainId, $url);
        }
        return ResponseStatus::SUCCESS_STATUS;
    }
}