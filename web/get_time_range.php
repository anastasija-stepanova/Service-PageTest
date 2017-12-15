<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$date = new DateTime();
$currentTime = $date->getTimestamp();

$timeRangeParam = WebServerRequest::getPostKeyValue('data');

if ($timeRangeParam != null)
{
    $jsonDecoded = json_decode($timeRangeParam, true);
    $lastError = json_last_error();
    $timeRangeFinished = [];

    if ($lastError === JSON_ERROR_NONE)
    {
        $timeRangeCreator = new TimeRangeCreator();
        $timeRangeFinished = $timeRangeCreator->createTimeRange();
    }
    else
    {
        echo ResponseStatus::JSON_ERROR;
        return;
    }

    $dataArray = [
        'timeRange' => $timeRangeFinished
    ];

    $json = json_encode($dataArray, true);
    echo $json;
}