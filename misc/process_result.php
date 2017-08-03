<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;
const STATUS_CODE_INDEX = 'statusCode';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$testIdsArray = $database->executeQuery("SELECT test_id FROM " . DatabaseTable::TEST_INFO .
                                        " WHERE is_completed = ?", [TestStatus::NOT_COMPLETED], PDO::FETCH_COLUMN);

for ($i = 0; $i < count($testIdsArray); $i++)
{
    $wptTestId = $testIdsArray[$i];

    $apiKey = $database->executeQuery("SELECT api_key FROM " . DatabaseTable::USER .
                                      " WHERE id = ?", [Config::DEFAULT_USER_ID], PDO::FETCH_COLUMN);

    $client = new WebPageTestClient($apiKey);

    $testStatus = $client->checkTestState($wptTestId);

    if ($testStatus != null && array_key_exists(STATUS_CODE_INDEX, $testStatus))
    {
        if ($testStatus[STATUS_CODE_INDEX] == SUCCESSFUL_STATUS)
        {
            $result = $client->getResult($wptTestId);
            $wptResponseHandler = new WebPageTestResponseHandler();
            $wptResponseHandler->handle($result);
        }
    }
}