<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if (array_key_exists('data', $_GET))
{
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $locations= $_GET['data'];
    $jsonDecode = json_decode($locations, true);

    if (array_key_exists('key', $jsonDecode))
    {
        $ttfbResult = $database->executeQuery("SELECT ttfb FROM " . DatabaseTable::AVERAGE_RESULT, [], PDO::FETCH_COLUMN);
        return $ttfbResult;
    }
}