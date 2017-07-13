<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;

if ($argv && array_key_exists(Config::FIRST_PARAM_ARGV, $argv))
{
    $client = new WebPageTestClient();
    $webPageTestResponseHandler = new WebPageTestResponseHandler();

    $testId = $argv[Config::FIRST_PARAM_ARGV];
    $testStatus = $client->checkStateTest($testId);

    if ($testStatus != null && array_key_exists('statusCode', $testStatus) && $testStatus['statusCode'] == SUCCESSFUL_STATUS)
    {
        $result = $client->getResult($testId);
        $webPageTestResponseHandler->handle($result);
    }
    else
    {
        echo 'Результаты теста еще не готовы';
    }
}
else
{
    echo 'Не передан параметр!';
}