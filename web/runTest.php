<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$siteUrl = $argv[1];
$client = new WebPageTestClient();

$testId = $client->runNewTest($siteUrl);

echo $testId;