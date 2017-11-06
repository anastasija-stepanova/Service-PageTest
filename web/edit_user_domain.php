<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsDomain = $webServerRequest->postKeyIsExists('domain');
$isExistsEditableDomain = $webServerRequest->postKeyIsExists('editableDomain');

if ($isExistsDomain !=  null)
{
    $databaseDataManager = new DatabaseDataManager();

    $json = $webServerRequest->getPostKeyValue('domain');
    $jsonDecoded = json_decode($json, true);
    $lastError = json_last_error();

    if ($lastError === JSON_ERROR_NONE)
    {
        $newDomain = $jsonDecoded['value'];

        $dataValidator = new DataValidator();

        $isDomain = $dataValidator->validateDomain($newDomain);
        if (!$isDomain)
        {
            echo RequireStatus::INVALID_DOMAIN;
            return;
        }

        $domainExists = $databaseDataManager->getDomainId($newDomain);

        if (!$domainExists)
        {
            $databaseDataManager->saveDomain($newDomain);

            if (array_key_exists('id', $domainExists))
            {
                $userId = $sessionClient->getUserId();
                $databaseDataManager->saveUserDomain($userId, $domainExists['id']);
                echo $newDomain;
            }
        }
    }
    else
    {
        echo $lastError;
    }
}
elseif ($isExistsEditableDomain)
{
    $databaseDataManager = new DatabaseDataManager();

    $json = $webServerRequest->getPostKeyValue('editableDomain');
    $jsonDecoded = json_decode($json, true);
    $lastError = json_last_error();

    if ($lastError === JSON_ERROR_NONE)
    {
        $currentDomain = $jsonDecoded['currentDomain'];
        $newDomain = $jsonDecoded['newDomain'];

        $dataValidator = new DataValidator();

        $isDomain = $dataValidator->validateDomain($newDomain);
        if (!$isDomain)
        {
            echo RequireStatus::INVALID_DOMAIN;
            return;
        }

        $editableDomainId = $databaseDataManager->getDomainId($currentDomain);


        if (array_key_exists('id', $editableDomainId))
        {
            $databaseDataManager->editDomain($editableDomainId['id'], $newDomain);
        }
    }
    else
    {
        echo $lastError;
    }
}