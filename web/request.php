<?php
require_once '../src/autoloader.php';

$siteUrl = 'http://ispringsolutions.com';
$client = new WebPageTestClient();

$testId = $client->runNewTest($siteUrl);
$testStatus = $client->checkStateTest($testId);
$result = $client->getResult('170705_VG_15YX');

$handlerJson = new WebPageTestResponseHandler();

$handlerJson->writeRawData($result);
$handlerJson->writeTestInfo($result);
$handlerJson->writeListUrls($result);
$handlerJson->writeAverageResult($result);
