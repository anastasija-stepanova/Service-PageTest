<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const INDEX_LOCATION = 'location';
const INDEX_URL = 'url';
const INDEX_WPT_LOCATION_ID = 'wpt_location_id';

$databaseDataManager = new DatabaseDataManager();
$usersId = $databaseDataManager->getUsersId();

foreach ($usersId as $userId)
{
    $userDomainsData = $databaseDataManager->getUserDomains($userId);
    $apiKey = $databaseDataManager->getUserApiKey($userId);

    foreach ($userDomainsData as $userDomain)
    {
        if (array_key_exists('id', $userDomain))
        {
            $domainId = $userDomain['id'];
            $userUrls = $databaseDataManager->getUserUrlsData($userId, $domainId);
            $userLocations = $databaseDataManager->getUserLocations($userId, $domainId);

            if (array_key_exists('domain_name', $userDomain))
            {
                $domainName = $userDomain['domain_name'];
                runNewTest($databaseDataManager, $apiKey, $userId, $userUrls, $userLocations, $domainName);
            }
        }
    }
}

function runNewTest($databaseDataProvider, $apiKey, $userId, $userUrls, $userLocations, $userDomain)
{
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