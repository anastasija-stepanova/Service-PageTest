<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;

$client = new WebPageTestClient();

if ($argv && array_key_exists(Config::FIRST_PARAM_ARGV, $argv))
{
    $testId = $argv[Config::FIRST_PARAM_ARGV];
    $testStatus = $client->checkStateTest($testId);

    if ($testStatus != null && array_key_exists('statusCode', $testStatus) && $testStatus['statusCode'] == SUCCESSFUL_STATUS)
    {
        $result = $client->getResult($testId);
        print_r($result);
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