<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if (array_key_exists('url', $_GET))
{
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $newUrl= $_GET['url'];
    $isUrl = preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $newUrl);
    if (!$isUrl)
    {
        echo 'Невалидный URL';
        exit();
    }

    $urlExists = $database->executeQuery("SELECT id FROM " . DatabaseTable::USER_URL . " WHERE url = ? LIMIT 1", [$newUrl]);
    if (!$urlExists)
    {
        $database->executeQuery("INSERT INTO " . DatabaseTable::USER_URL . " (user_id, url) VALUES (?, ?)", [Config::DEFAULT_USER_ID, $newUrl]);
        echo $newUrl;
    }
}