<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;
const STATUS_CODE_INDEX = 'statusCode';

$databaseDataProvider = new DatabaseDataManager();

$userIds = $databaseDataProvider->getUsersId();

$pendingTestIds = $databaseDataProvider->getPendingTestIds();

foreach ($userIds as $userId)
{
    $apiKey = $databaseDataProvider->getUserApiKey($userId);

    foreach ($pendingTestIds as $pendingTestId)
    {
        $wptTestId = $pendingTestId;

        $client = new WebPageTestClient($apiKey);

        $testStatus = $client->checkTestState($wptTestId);

        if ($testStatus != null && array_key_exists(STATUS_CODE_INDEX, $testStatus))
        {
            if ($testStatus[STATUS_CODE_INDEX] == SUCCESSFUL_STATUS)
            {
                $databaseDataProvider->updateTestInfoStatus($wptTestId);
                $result = $client->getResult($wptTestId);
                $wptResponseHandler = new WebPageTestResponseHandler();
                $wptResponseHandler->handle($result);
            }
        }
    }
}