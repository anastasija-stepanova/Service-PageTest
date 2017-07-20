<?php
require_once __DIR__ . '/../autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;
const PRINT_RESULT_PARAM = 1;
const SAVE_RESULT_PARAM = 2;

if ($argc != Config::THREE_PARAMS_ARGC)
{
    echo 'Неверно переданы параметры!';

}
$client = new WebPageTestClient();
$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$testId = $argv[1];

$dataArray = $database->executeQuery("SELECT test_id FROM " . DatabaseTable::TEST_INFO . " WHERE id = ?", [$testId]);

if ($dataArray && $dataArray[0] && $dataArray[0]['test_id'])
{
    $wptTestId = $dataArray[0]['test_id'];
    $testStatus = $client->checkTestState($wptTestId);

    if ($testStatus != null && array_key_exists('statusCode', $testStatus) && $testStatus['statusCode'] == SUCCESSFUL_STATUS)
    {
        $result = $client->getResult($wptTestId);

        switch ($argv[2])
        {
            case PRINT_RESULT_PARAM:
                print_r($result);
                break;
            case SAVE_RESULT_PARAM:
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