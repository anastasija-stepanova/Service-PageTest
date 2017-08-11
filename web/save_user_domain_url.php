<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!isset($_SESSION['userId']))
{
    header('Location: auth.php');
    exit();
}

if (array_key_exists('url', $_POST))
{
    $databaseDataProvider = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

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

    $urlExists = $databaseDataProvider->getDomainId($newUrl);

    if (!$urlExists)
    {
        $domainsId = $databaseDataProvider->getDomainsId();

        foreach ($domainsId as $domainId)
        {
            $databaseDataProvider->saveUserDomainUrl($domainId, $newUrl);
            echo $newUrl;
        }
    }
}