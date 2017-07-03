<?php
require_once 'include/common.inc.php';

$siteUrl = 'http://ispringsolutions.com';
$apiKey = 'A.7a90c9f8293c2f09d0ea68c78e19c1f6';
$client = new WebPageTestClient($apiKey);

$testId = $client->runNewTest($siteUrl);

$checkTestId = $client->checkStateTest($testId);

$result = $client->getResult($checkTestId);

dbQuery("INSERT INTO raw_data (json_data) VALUES ($result)");
print_r($result);