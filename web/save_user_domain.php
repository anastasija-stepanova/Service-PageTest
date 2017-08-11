<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!isset($_SESSION['userId']))
{
    header('Location: auth.php');
    exit();
}

if (array_key_exists('domain', $_POST))
{
    $databaseDataProvider = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $json = $_POST['domain'];
    $jsonDecode = json_decode($json, true);
    $newDomain = $jsonDecode['value'];

    $dataValidator = new DataValidator();

    $isDomain = $dataValidator->validateDomain($newDomain);
    if (!$isDomain)
    {
        echo 'Невалидное имя домена';
        exit();
    }

    $domainExists = $databaseDataProvider->getDomainId($newDomain);

    if (!$domainExists)
    {
        $databaseDataProvider->saveDomain($newDomain);

        $domainId = $databaseDataProvider->getDomainId($newDomain);
        if (array_key_exists('id', $domainId))
        {
            $databaseDataProvider->saveUserDomain($_SESSION['userId'], $domainId['id']);
           echo $newDomain;
        }
    }
}