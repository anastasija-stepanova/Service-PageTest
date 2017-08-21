<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();

$sessionClient->checkArraySession();

if (array_key_exists('data', $_POST))
{
    $databaseDataManager = new DatabaseDataManager();

    $testResultParam = $_POST['data'];
    $jsonDecode = json_decode($testResultParam, true);

    if (array_key_exists('domainId', $jsonDecode))
    {
        $domainId = $jsonDecode['domainId'];
        if (array_key_exists('locationId', $jsonDecode))
        {
            $locationId = $jsonDecode['locationId'];

            if (array_key_exists('typeView', $jsonDecode))
            {
                $typeView = $jsonDecode['typeView'];
                $dataArray = $databaseDataManager->getTestResult($_SESSION['userId'], $domainId, $locationId, $typeView);
            }
        }
    }
    else
    {
        $dataArray = $databaseDataManager->getTestResult($_SESSION['userId']);
    }

    $array = [
        'testResult' => $dataArray
    ];

    $json = json_encode($array, true);
    echo $json;
}