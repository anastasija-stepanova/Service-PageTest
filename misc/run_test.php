<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const INDEX_LOCATION = 'location';
const INDEX_URL = 'url';
const INDEX_ID = 'id';
const INDEX_DOMAIN_NAME = 'domain_name';

$databaseDataManager = new DatabaseDataManager();
$usersId = $databaseDataManager->getUsersId();

foreach ($usersId as $userId)
{
    $userDomainsData = $databaseDataManager->getUserDomains($userId);
    $apiKey = $databaseDataManager->getUserApiKey($userId);

    foreach ($userDomainsData as $userDomain)
    {
        if (array_key_exists(INDEX_ID, $userDomain))
        {
            $domainId = $userDomain[INDEX_ID];
            $userUrls = $databaseDataManager->getUserUrlsData($userId, $domainId);
            $userLocations = $databaseDataManager->getUserLocations($userId, $domainId);

            if (array_key_exists(INDEX_DOMAIN_NAME, $userDomain))
            {
                $domainName = $userDomain[INDEX_DOMAIN_NAME];
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