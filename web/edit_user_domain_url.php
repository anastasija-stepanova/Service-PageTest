<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsPreservedUrl = $webServerRequest->postKeyIsExists('preservedUrl');
$isExistsDeletableUrls = $webServerRequest->postKeyIsExists('deletableUrls');

if ($isExistsPreservedUrl != null)
{
    $databaseDataManager = new DatabaseDataManager();

    $preservedUrl = $webServerRequest->getPostKeyValue('preservedUrl');
    $jsonDecoded = json_decode($preservedUrl, true);
    $lastError = json_last_error();

    if ($lastError === JSON_ERROR_NONE)
    {
        print_r($jsonDecoded);
        $domain = $jsonDecoded['domain'];
        $newUrl = $jsonDecoded['url'];

        $dataValidator = new DataValidator();

        $isUrl = $dataValidator->validateUrl($newUrl);
        if (!$isUrl)
        {
            echo 1;
            return;
        }

        $domainId = $databaseDataManager->getUserDomain($domain);

        if (array_key_exists('id', $domainId))
        {
            $domainId = $domainId['id'];
        }

        $urlExists = $databaseDataManager->doesUserUrlExists($domainId, $newUrl);

        if (!$urlExists)
        {
            $databaseDataManager->saveUserDomainUrl($domainId, $newUrl);
            echo $newUrl;
        }
    }
    else
    {
        echo $lastError;
    }
}
else if ($isExistsDeletableUrls)
{
    $databaseDataManager = new DatabaseDataManager();

    $removableUrls = $webServerRequest->getPostKeyValue('deletableUrls');

    $lastError = json_last_error();
    if ($lastError === JSON_ERROR_NONE)
    {
        $jsonDecoded = json_decode($removableUrls, true);
        $domain = $jsonDecoded['domain'];
        $urls = $jsonDecoded['urls'];

        $domainId = $databaseDataManager->getUserDomain($domain);

        if (array_key_exists('id', $domainId))
        {
            $domainId = $domainId['id'];
        }

        foreach ($urls as $url)
        {
            $databaseDataManager->deleteUrl($domainId, $url);
        }
    }
    else
    {
        echo 1;
    }
}