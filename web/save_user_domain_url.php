<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsPreservedUrl = $webServerRequest->postKeyIsExists('preservedUrl');
$isExistsRemovableUrls = $webServerRequest->postKeyIsExists('removableUrls');

if ($isExistsPreservedUrl)
{
    $databaseDataManager = new DatabaseDataManager();

    $preservedUrl = $webServerRequest->getPostKeyValue('preservedUrl');

    $lastError = json_last_error();
    if ($lastError === JSON_ERROR_NONE)
    {
        $jsonDecoded = json_decode($preservedUrl, true);
        $domain = $jsonDecoded['domain'];
        $newUrl = $jsonDecoded['url'];

        print_r($newUrl);
        $dataValidator = new DataValidator();

        $isUrl = $dataValidator->validateUrl($newUrl);
        if (!$isUrl)
        {
            echo 'Невалидный URL';
            exit();
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
        return $lastError;
    }
}
else if ($isExistsRemovableUrls)
{
    $databaseDataManager = new DatabaseDataManager();

    $removableUrls = $webServerRequest->getPostKeyValue('removableUrls');

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
            print_r($url);
            $databaseDataManager->deleteUrl($domainId, $url);
        }
    }
    else
    {
        echo "Ошибка в переданных данных!";
    }
}