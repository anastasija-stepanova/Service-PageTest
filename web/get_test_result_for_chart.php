<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const DEFAULT_TYPE_VIEW = 1;
const DAY_PRESET = 1;
const WEEK_PRESET = 2;
const DAY_S = 86400;
const WEEK_S = 604800;
const MONTH_S = 2629743;

$sessionClient = new SessionClient();

$sessionClient->checkArraySession();

$date = new DateTime();
$currentTime = $date->getTimestamp();

if (array_key_exists('data', $_POST))
{
    $databaseDataManager = new DatabaseDataManager();

    $testResultParam = $_POST['data'];
    $jsonDecode = json_decode($testResultParam, true);
    $domainId = null;
    $locationId = null;
    $typeView = null;
    $dataArray = null;

    if (array_key_exists('domainId', $jsonDecode))
    {
        $domainId = $jsonDecode['domainId'];
        if (array_key_exists('locationId', $jsonDecode))
        {
            $locationId = $jsonDecode['locationId'];
            if (array_key_exists('typeView', $jsonDecode))
            {
                $typeView = $jsonDecode['typeView'];
                if (array_key_exists('presetId', $jsonDecode))
                {
                    $presetId = $jsonDecode['presetId'];
                    if ($presetId == DAY_PRESET)
                    {
                        $startTime = $currentTime - DAY_S;
                    }
                    elseif ($presetId == WEEK_PRESET)
                    {
                        $startTime = $currentTime - WEEK_S;
                    }
                    else
                    {
                        $startTime = $currentTime - MONTH_S;
                    }

                    $dataArray = $databaseDataManager->getTestResult($_SESSION['userId'], $domainId, $locationId, $typeView, $currentTime, $startTime);
                }
            }
        }
    }
    else
    {
        $defaultDomainId = $databaseDataManager->getDefaultUserDomain();
        $defaultLocationId = $databaseDataManager->getDefaultUserDomainLocation();
        $startTime = $currentTime - WEEK_S;
        $dataArray = $databaseDataManager->getTestResult($_SESSION['userId'], $defaultDomainId, $defaultLocationId, DEFAULT_TYPE_VIEW, $currentTime, $startTime);
    }

    $finishedData = [];
    foreach ($dataArray as $item)
    {
        $finishedData[$item['user_domain_id']][$item['url']]['ttfb'][] = $item['ttfb'];
        $finishedData[$item['user_domain_id']][$item['url']]['doc_time'][] = $item['doc_time'];
        $finishedData[$item['user_domain_id']][$item['url']]['fully_loaded'][] = $item['fully_loaded'];
        $finishedData[$item['user_domain_id']][$item['url']]['time'][] = $item['DATE_FORMAT(ar.completed_time, \'%e %M\')'];
    }


    $testResult = [
        'testResult' => $finishedData
    ];

    $json = json_encode($testResult, true);
    echo $json;
}