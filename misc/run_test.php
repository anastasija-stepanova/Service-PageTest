<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const INDEX_LOCATION = 'location';
const INDEX_URL = 'url';
const INDEX_WPT_LOCATION_ID = 'wpt_location_id';

$databaseDataProvider = new DatabaseDataManager();
$userIds = $databaseDataProvider->getUsersId();

foreach ($userIds as $userId)
{
    $userDomains = $databaseDataProvider->getUserDomains($userId);
    $userUrls = $databaseDataProvider->getUserUrlsData($userId);
    $userLocations = $databaseDataProvider->getUserLocations($userId);
    $apiKey = $databaseDataProvider->getUserApiKey($userId);

    foreach ($userDomains as $userDomain)
    {
        runNewTest($apiKey, $userId, $userUrls, $userLocations, $userDomain);
    }
}

function runNewTest($apiKey, $userId, $userUrls, $userLocations, $userDomain)
{
    $databaseDataProvider = new DatabaseDataManager();

    foreach ($userUrls as $userUrl)
    {
        $fullUrl = $userDomain . $userUrl[INDEX_URL];

        $client = new WebPageTestClient($apiKey);

        foreach ($userLocations as $userLocation)
        {
            $wptTestId = $client->runNewTest($fullUrl, $userLocation[INDEX_LOCATION]);
            $databaseDataProvider->saveTestInfo($userId, $userUrl, $userLocation, $wptTestId);
        }
    }
}