<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if (array_key_exists('data', $_POST))
{
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $ttfbParam = $_POST['data'];
    $jsonDecode = json_decode($ttfbParam, true);

    if (array_key_exists('result', $jsonDecode))
    {
        $dataArray = $database->executeQuery("SELECT ttfb, load_time, requests, completed_time FROM " . DatabaseTable::AVERAGE_RESULT);

        $ttfbArray = [];
        $loadTimeArray = [];
        $requestsArray = [];
        $timeArray = [];

        foreach ($dataArray as $item)
        {
            $ttfbArray[] = $item['ttfb'];
            $loadTimeArray[] = $item['load_time'];
            $requestsArray[] = $item['requests'];
            $date = new DateTime($item['completed_time']);
            $time = $date->format('m/d');
            $timeArray[] = $time;
        }

        $readyDataArray = [
            'ttfb' =>$ttfbArray,
            'loadTime' => $loadTimeArray,
            'requests' => $requestsArray,
            'time' => $timeArray
        ];

        $json = json_encode($readyDataArray);
        print_r($json);
    }
}