<?php
require_once __DIR__ . '/../autoloader.inc.php';

if ($argc != Config::TWO_PARAMS_ARGC)
{
    echo 'Неверно передан параметр!';
    exit();
}

$siteUrl = $argv[1];
$client = new WebPageTestClient();
$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$wptTestId = $client->runNewTest($siteUrl);
$database->executeQuery("INSERT INTO " . DatabaseTable::TEST_INFO . " (user_id, test_id) VALUES (?, ?)", [Config::DEFAULT_USER_ID, $wptTestId]);

$dataArray = $database->executeQuery("SELECT id FROM " . DatabaseTable::TEST_INFO . " WHERE test_id = ?", [$wptTestId]);

if (array_key_exists(0, $dataArray) && array_key_exists('id', $dataArray[0]))
{
    $testId = $dataArray[0]['id'];
    echo $testId;
}