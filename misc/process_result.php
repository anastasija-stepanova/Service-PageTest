<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;
const STATUS_CODE_INDEX = 'statusCode';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
$databaseDataProvider = new DatabaseDataProvider();

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
                $database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO . " SET test_status = ? WHERE test_id = ?",
                                        [TestStatus::PROCESSED, $wptTestId]);

                $result = $client->getResult($wptTestId);
                $wptResponseHandler = new WebPageTestResponseHandler();
                $wptResponseHandler->handle($result);
            }
        }
    }
}