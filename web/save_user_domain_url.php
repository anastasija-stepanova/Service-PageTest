<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!array_key_exists('userId', $_SESSION))
{
    header('Location: auth.php');
    exit();
}

if (array_key_exists('url', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $json = $_POST['url'];
    $jsonDecode = json_decode($json, true);
    $newUrl = $jsonDecode['value'];

    $dataValidator = new DataValidator();

    $isUrl = $dataValidator->validateUrl($newUrl);
    if (!$isUrl)
    {
        echo 'Невалидный URL';
        exit();
    }

    $urlExists = $databaseDataManager->getDomainId($newUrl);

    if (!$urlExists)
    {
        $domainsId = $databaseDataManager->getDomainsId();

        foreach ($domainsId as $domainId)
        {
            $databaseDataManager->saveUserDomainUrl($domainId, $newUrl);
            echo $newUrl;
        }
    }
}