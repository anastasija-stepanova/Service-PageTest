<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$testIdsArray = $argv;

for ($i = 0; $i < count($testIdsArray); $i++)
{
    $dataArray = $database->selectOneRow("SELECT test_id FROM " . DatabaseTable::TEST_INFO . " WHERE id = ?", [$testIdsArray[$i]]);

    if (array_key_exists('test_id', $dataArray))
    {
        $wptTestId = $dataArray['test_id'];

        $client = new WebPageTestClient();

        $testStatus = $client->checkTestState($wptTestId);

        if ($testStatus != null && array_key_exists('statusCode', $testStatus) && $testStatus['statusCode'] == SUCCESSFUL_STATUS)
        {
            $result = $client->getResult($wptTestId);
            $wptResponseHandler = new WebPageTestResponseHandler();
            $wptResponseHandler->handle($result);
        }
    }
}