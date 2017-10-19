<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsDomain = $webServerRequest->postKeyIsExists('domain');

if ($isExistsDomain)
{
    $databaseDataManager = new DatabaseDataManager();

    $json = $webServerRequest->getPostKeyValue('domain');
    $jsonDecode = json_decode($json, true);
    $lastError = json_last_error();

    if ($lastError === JSON_ERROR_NONE)
    {
        $newDomain = $jsonDecode['value'];

        $dataValidator = new DataValidator();

        $isDomain = $dataValidator->validateDomain($newDomain);
        if (!$isDomain)
        {
            echo 'Невалидное имя домена';
            exit();
        }

        $domainExists = $databaseDataManager->getDomainId($newDomain);

        if (!$domainExists)
        {
            $databaseDataManager->saveDomain($newDomain);

            $domainId = $databaseDataManager->getDomainId($newDomain);
            if (array_key_exists('id', $domainId))
            {
                $userId = $sessionClient->getUserId();
                $databaseDataManager->saveUserDomain($userId, $domainId['id']);
                echo $newDomain;
            }
        }
    }
    else
    {
        return $lastError;
    }
}