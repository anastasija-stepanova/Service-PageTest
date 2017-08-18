<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();

$sessionClient->checkArraySession();

if (array_key_exists('data', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $testResultParam = $_POST['data'];
    $jsonDecode = json_decode($testResultParam, true);

    if (array_key_exists('result', $jsonDecode))
    {
        $dataArray = $databaseDataManager->getTestResult($_SESSION['userId']);

        $array = [
            'testResult' => $dataArray
        ];

        $json = json_encode($array, true);
        echo $json;
    }
}