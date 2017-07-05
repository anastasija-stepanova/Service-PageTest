<?php
require_once '../src/Autoloader.php';

$siteUrl = 'http://ispringsolutions.com';
$client = new WebPageTestClient();

$testId = $client->runNewTest($siteUrl);

$checkTestId = $client->checkStateTest($testId);
print_r($checkTestId);