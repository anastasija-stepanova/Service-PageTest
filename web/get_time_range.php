<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$date = new DateTime();
$currentTime = $date->getTimestamp();

$timeRangeParam = WebServerRequest::getPostKeyValue('data');

if ($timeRangeParam != null)
{
    $databaseDataManager = new DatabaseDataManager();
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