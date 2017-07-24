<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if ($argc != 3)
{
    echo 'Неверно передан параметр!';
    exit();
}

$siteUrl = $argv[1];
$location = $argv[2];
$client = new WebPageTestClient();
$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$wptTestId = $client->runNewTest($siteUrl, $location);
$database->executeQuery("INSERT INTO " . DatabaseTable::TEST_INFO . " (user_id, test_id) VALUES (?, ?)", [Config::DEFAULT_USER_ID, $wptTestId]);

$dataArray = $database->selectOneRowDatabase("SELECT id FROM " . DatabaseTable::TEST_INFO . " WHERE test_id = ?", [$wptTestId]);

if (array_key_exists('id', $dataArray))
{
    $testId = $dataArray['id'];
    echo $testId;
}