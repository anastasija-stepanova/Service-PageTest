<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!isset($_SESSION['userId']))
{
    header('Location: auth.php');
    exit();
}

if (array_key_exists('data', $_POST))
{
    $databaseDataProvider = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $ttfbParam = $_POST['data'];
    $jsonDecode = json_decode($ttfbParam, true);

    if (array_key_exists('result', $jsonDecode))
    {
        $dataArray = $databaseDataProvider->getTestResult($_SESSION['userId']);

        $ttfbArray = [];
        $docTimeArray = [];
        $fullyLoadedArray = [];
        $timeArray = [];

        foreach ($dataArray as $item)
        {
            $ttfbArray[] = $item['ttfb'];
            $docTimeArray[] = $item['doc_time'];
            $fullyLoadedArray[] = $item['fully_loaded'];
            $date = new DateTime($item['completed_time']);
            $time = $date->format('m/d');
            $timeArray[] = $time;
        }

        $readyDataArray = [
            'ttfb' =>$ttfbArray,
            'docTime' => $docTimeArray,
            'fullyLoaded' => $fullyLoadedArray,
            'time' => $timeArray
        ];

        $json = json_encode($readyDataArray);
        print_r($json);
    }
}