<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!array_key_exists('userId', $_SESSION))
{
    header('Location: auth.php');
    exit();
}

if (array_key_exists('data', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $ttfbParam = $_POST['data'];
    $jsonDecode = json_decode($ttfbParam, true);

    if (array_key_exists('result', $jsonDecode))
    {
        $dataArray = $databaseDataManager->getTestResult($_SESSION['userId']);
        $testTime = $databaseDataManager->getTestTime($_SESSION['userId']);
        $uniqueTime = array_unique($testTime);
        $uniqueTime = array_values($uniqueTime);

        $array = [
            'testResult' => $dataArray,
            'time' => $uniqueTime
        ];

        $json = json_encode($array, true);
        print_r($json);
    }
}