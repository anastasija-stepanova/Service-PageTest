<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if (array_key_exists('data', $_POST))
{
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $ttfbResult = $_POST['data'];
    $jsonDecode = json_decode($ttfbResult, true);

    if (array_key_exists('result', $jsonDecode))
    {
        $ttfb = $database->executeQuery("SELECT ttfb FROM " . DatabaseTable::AVERAGE_RESULT, [], PDO::FETCH_COLUMN);
        $time = $database->executeQuery("SELECT completed_time FROM " . DatabaseTable::TEST_INFO, [], PDO::FETCH_COLUMN);
        $array = [
            'ttfb' => $ttfb,
            'time' => $time
        ];
        $json = json_encode($array);
        print_r($json);
    }
}