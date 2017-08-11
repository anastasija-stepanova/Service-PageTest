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
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    $databaseDataProvider = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $newUrl= $_POST['url'];

    $dataValidator = new DataValidator();

    $isUrl = $dataValidator->validateUrl($newUrl);
    if (!$isUrl)
    {
        echo 'Невалидный URL';
        exit();
    }

    $urlExists = $databaseDataProvider->urlIsExists($newUrl);

    if (!$urlExists)
    {
        $database->executeQuery("INSERT INTO " . DatabaseTable::USER_URL .
                                " (user_id, url) VALUES (?, ?)", [$_SESSION['userId'], $newUrl]);
        echo $newUrl;
    }
}