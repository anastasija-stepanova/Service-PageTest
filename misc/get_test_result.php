<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;

const PRINT_RESULT_MODE= 1;
const SAVE_RESULT_MODE = 2;

if ($argc != 3)
{
    echo 'Неверно переданы параметры!';
    exit();
}

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$apiKey = $database->executeQuery("SELECT api_key FROM " . DatabaseTable::USER .
                                  " WHERE id = ?", [Config::DEFAULT_USER_ID], PDO::FETCH_COLUMN);

$client = new WebPageTestClient($apiKey);

$testId = $argv[1];

$dataArray = $database->selectOneRow("SELECT test_id FROM " . DatabaseTable::TEST_INFO . " WHERE id = ?", [$testId]);

if (array_key_exists('test_id', $dataArray))
{
    $wptTestId = $dataArray['test_id'];
    $testStatus = $client->checkTestState($wptTestId);

    if ($testStatus != null && array_key_exists('statusCode', $testStatus) && $testStatus['statusCode'] == SUCCESSFUL_STATUS)
    {
        $result = $client->getResult($wptTestId);

        switch ($argv[2])
        {
            case PRINT_RESULT_MODE:
                print_r($result);
                break;
            case SAVE_RESULT_MODE:
                $wptResponseHandler = new WebPageTestResponseHandler();
                $wptResponseHandler->handle($result);
                break;
        }
    }
    else
    {
        echo 'Результаты теста еще не готовы';
    }
}