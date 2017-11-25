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

    public function saveNewUrl(string $json): void
    {
        $jsonDecoded = json_decode($json, true);
        $lastError = json_last_error();

        if ($lastError === JSON_ERROR_NONE)
        {
            $domain = $jsonDecoded['domain'];
            $newUrl = $jsonDecoded['url'];

            $isUrl = DataValidator::validateUrl($newUrl);
            if (!$isUrl)
            {
                echo ResponseStatus::INVALID_URL;
                return;
            }

            $domainId = $this->databaseDataManager->getUserDomain($domain);

            if (array_key_exists('id', $domainId))
            {
                $domainId = $domainId['id'];
            }

            $urlExists = $this->databaseDataManager->doesUserUrlExists($domainId, $newUrl);

            if (!$urlExists)
            {
                $this->databaseDataManager->saveUserDomainUrl($domainId, $newUrl);
                echo $newUrl;
            }
        }
        else
        {
            echo $lastError;
        }
    }

    public function deleteUrl(string $json): void
    {
        $jsonDecoded = json_decode($json, true);
        $lastError = json_last_error();

        if ($lastError === JSON_ERROR_NONE)
        {
            $domain = $jsonDecoded['domain'];
            $urls = $jsonDecoded['urls'];

            $domainId = $this->databaseDataManager->getUserDomain($domain);

            if (array_key_exists('id', $domainId))
            {
                $domainId = $domainId['id'];
            }

            foreach ($urls as $url)
            {
                $this->databaseDataManager->deleteUrl($domainId, $url);
            }
        }
        else
        {
            echo $lastError;
        }
    }
}