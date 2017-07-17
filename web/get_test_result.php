<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;

if ($argc == Config::THREE_PARAMS_ARGC && array_key_exists(Config::FIRST_PARAM_ARGV, $argv))
{
    $client = new WebPageTestClient();
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $testId = $argv[Config::FIRST_PARAM_ARGV];

    $dataArray = $database->executeQuery("SELECT test_id FROM " . DatabaseTable::TEST_INFO . " WHERE id = ?", [$testId]);

    if ($dataArray && $dataArray[0] && $dataArray[0]['test_id'])
    {
        $wptTestId = $dataArray[0]['test_id'];
        $testStatus = $client->checkTestState($wptTestId);

        if ($testStatus != null && array_key_exists('statusCode', $testStatus) && $testStatus['statusCode'] == SUCCESSFUL_STATUS)
        {
            $result = $client->getResult($wptTestId);

            if ($argv[Config::SECOND_PARAM_ARGV] == 1)
            {
                print_r($result);
            }
            elseif ($argv[Config::SECOND_PARAM_ARGV] == 2)
            {
                $wptResponseHandler = new WebPageTestResponseHandler();
                $wptResponseHandler->handle($result);
            }
        }
        else
        {
            echo 'Результаты теста еще не готовы';
        }
    }
}
else
{
    echo 'Неверно переданы параметры!';
}