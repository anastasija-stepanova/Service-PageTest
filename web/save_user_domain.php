<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!array_key_exists('userId', $_SESSION))
{
    header('Location: auth.php');
    exit();
}

if (array_key_exists('domain', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

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

    $domainExists = $databaseDataManager->getDomainId($newDomain);

    if (!$domainExists)
    {
        $databaseDataManager->saveDomain($newDomain);

        $domainId = $databaseDataManager->getDomainId($newDomain);
        if (array_key_exists('id', $domainId))
        {
            $databaseDataManager->saveUserDomain($_SESSION['userId'], $domainId['id']);
           echo $newDomain;
        }
    }
}