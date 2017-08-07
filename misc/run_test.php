<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const INDEX_LOCATION = 'location';
const INDEX_URL = 'url';
const INDEX_ID = 'id';
const INDEX_WPT_LOCATION_ID = 'wpt_location_id';

$databaseDataProvider = new DatabaseDataProvider();
$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
$userIds = $databaseDataProvider->getUsersId();

foreach ($userIds as $userId)
{
    $userUrls = $databaseDataProvider->getUserUrls($userId);
    $userLocations = $databaseDataProvider->getUserLocations($userId);
    $apiKey = $databaseDataProvider->getUserApiKey($userId);

    runNewTest($database, $apiKey, $userId, $userUrls, $userLocations);
}

function runNewTest($database, $apiKey, $userId, $userUrls, $userLocations)
{
    $client = new WebPageTestClient($apiKey);

    foreach ($userUrls as $userUrl)
    {
        foreach ($userLocations as $userLocation)
        {
            $wptTestId = $client->runNewTest($userUrl[INDEX_URL], $userLocation[INDEX_LOCATION]);
            $database->executeQuery("INSERT INTO " . DatabaseTable::TEST_INFO . " (user_id, url_id, location_id, test_id, test_status)
                                     VALUES (?, ?, ?, ?, ?)", [$userId, $userUrl[INDEX_ID], $userLocation[INDEX_WPT_LOCATION_ID],  $wptTestId, TestStatus::NOT_COMPLETED]);
        }
    }
}