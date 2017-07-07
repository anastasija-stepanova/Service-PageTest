<?php
require_once '../src/autoloader.php';

$siteUrl = 'http://ispringsolutions.com';
$client = new WebPageTestClient();

$testId = $client->runNewTest($siteUrl);

$testStatus = $client->checkStateTest($testId);

$result = $client->getResult('170705_VG_15YX');
print_r($result);

$handlerJson = new HandlerJson();
$handlerJson->handleResponse('170705_VG_15YX');