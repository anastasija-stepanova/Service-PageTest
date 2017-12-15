<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const DEFAULT_TYPE_VIEW = 1;
const DATA_KEYS_FOR_CHARTS = ['domainId', 'locationId', 'typeView', 'minTime', 'maxTime'];
const AXIS_Y_NAMES = ['TTFB (ms)', 'Document Complete (ms)', 'Fully Load Time (ms)'];
const CHART_CONTAINER_NAME = '.ct-chart';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$date = new DateTime();
$currentTime = $date->getTimestamp();

$testResultParam = WebServerRequest::getPostKeyValue('data');

if ($testResultParam != null)
{
    $databaseDataManager = new DatabaseDataManager();

    $jsonDecoded = json_decode($testResultParam, true);
    $lastError = json_last_error();
    if ($lastError === JSON_ERROR_NONE)
    {
        $dataArray = initializeDataArray($sessionManager, $jsonDecoded, $currentTime, $databaseDataManager);

        $finishedData = [];
        $ttfbArray = [];
        $docTimeArray = [];
        $fullyLoadedArray = [];
        foreach ($dataArray as $item)
        {
            $ttfbArray[] = $item['completed_time'];
            $ttfbArray[] = $item['ttfb'];
            $docTimeArray[] = $item['completed_time'];
            $docTimeArray[] = $item['doc_time'];
            $fullyLoadedArray[] = $item['completed_time'];
            $fullyLoadedArray[] = $item['fully_loaded'];
            $finishedData[$item['user_domain_id']][$item['url']]['ttfb'][] = $ttfbArray;
            $finishedData[$item['user_domain_id']][$item['url']]['doc_time'][] = $docTimeArray;
            $finishedData[$item['user_domain_id']][$item['url']]['fully_loaded'][] = $fullyLoadedArray;
            $ttfbArray = [];
            $docTimeArray = [];
            $fullyLoadedArray = [];
        }

        $testResult = [
            'testResult' => $finishedData,
            'axisYName' => AXIS_Y_NAMES,
            'chartContainerName' => CHART_CONTAINER_NAME,
        ];

        $json = json_encode($testResult, true);
        echo $json;
    }
    else
    {
        echo ResponseStatus::JSON_ERROR;
    }
}

function checkParamsForChart(array $array): bool
{
    $isExists = null;
    foreach (DATA_KEYS_FOR_CHARTS as $key)
    {
        $isExists = array_key_exists($key, $array) && $array[$key] != null ? true : false;
    }
    return $isExists;
}

function initializeDataArray(SessionManager $sessionManager, array $jsonDecoded, int $currentTime, DatabaseDataManager $databaseDataManager): array
{
    $userId = $sessionManager->getUserId();
    if (checkParamsForChart($jsonDecoded))
    {
        $domainId = $jsonDecoded['domainId'];
        $locationId = $jsonDecoded['locationId'];
        $typeView = $jsonDecoded['typeView'];
        $minTime = $jsonDecoded['minTime'];
        $maxTime = $jsonDecoded['maxTime'];
        $dataArray = $databaseDataManager->getTestResult($userId, $domainId, $locationId, $typeView, $minTime, $maxTime);
    }
    else
    {
        $defaultDomainId = $databaseDataManager->getDefaultUserDomain();
        $defaultLocationId = $databaseDataManager->getDefaultUserDomainLocation();
        $startTime = $currentTime - DateUtils::SECONDS_IN_WEEK;
        $dataArray = $databaseDataManager->getTestResult($userId, $defaultDomainId, $defaultLocationId, DEFAULT_TYPE_VIEW, $startTime, $currentTime);
    }

    return $dataArray;
}