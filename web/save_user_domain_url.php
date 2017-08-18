<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();

$sessionClient->checkArraySession();

if (array_key_exists('data', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $json = $_POST['data'];
    $jsonDecode = json_decode($json, true);
    $domain = $jsonDecode['domain'];
    $newUrl = $jsonDecode['url'];

    $dataValidator = new DataValidator();

    $isUrl = $dataValidator->validateUrl($newUrl);
    if (!$isUrl)
    {
        echo 'Невалидный URL';
        exit();
    }

    $domainId = $databaseDataManager->getUserDomain($domain);

    if (array_key_exists(0, $domainId))
    {
        $domainId = $domainId[0];
    }

    $urlExists = $databaseDataManager->doesUserUrlExists($domainId, $newUrl);

    if (!$urlExists)
    {
        $databaseDataManager->saveUserDomainUrl($domainId, $newUrl);
        echo $newUrl;
    }
}