<?php
require_once 'common.inc.php';
$client = new classClient();
$siteUrl = 'http://ispringsolutions.com';
$apiKey = 'A.7a90c9f8293c2f09d0ea68c78e19c1f6';
echo $client->sendRequest($siteUrl, $apiKey);
echo $client->getResponse();