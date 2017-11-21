<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionWrapper();
$sessionClient->checkArraySession();

$date = new DateTime();
$currentTime = $date->getTimestamp();

$webServerRequest = new WebServerRequest();
$isExistsPostData = $webServerRequest->postKeyExists('data');

if ($isExistsPostData)
{
    $databaseDataManager = new DatabaseDataManager();
    $timeRangeParam = $webServerRequest->getPostKeyValue('data');
    $jsonDecoded = json_decode($timeRangeParam, true);
    $lastError = json_last_error();
    $timeRangeFinished = null;

    if ($lastError === JSON_ERROR_NONE)
    {
        $timeRange = $databaseDataManager->getTimeRange();
        foreach ($timeRange as $value)
        {
            foreach ($value as $time)
            {
                $timeRangeFinished[] = $time;
            }
        }
    }
    else
    {
        echo $lastError;
        return;
    }

    $dataArray = [
        'timeRange' => $timeRangeFinished
    ];

    $json = json_encode($dataArray, true);
    echo $json;
}