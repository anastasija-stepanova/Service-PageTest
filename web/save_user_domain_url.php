<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();

$sessionClient->checkArraySession();

if (array_key_exists('preservedUrl', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $preservedUrl = $_POST['preservedUrl'];

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
}
else if (array_key_exists('removableUrls', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $removableUrls = $_POST['removableUrls'];

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
            $databaseDataManager->deleteUrls($domainId, $url);
        }
    }
}