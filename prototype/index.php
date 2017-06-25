<?php
use GuzzleHttp\Client;

require_once 'vendor/autoload.php';

$client = new Client();
$urlTest = 'ispringsolutions.com';
$apiKey = 'A.7a90c9f8293c2f09d0ea68c78e19c1f6';
$response = $client->request('POST', "http://www.webpagetest.org/runtest.php?url=$urlTest&runs=1&f=xml&k=$apiKey");
$xmlResponse = $response->getBody()->getContents();
$xmlResponseElement = new SimpleXMLElement($xmlResponse);
$xmlUrl = $xmlResponseElement->data[0]->xmlUrl;
$xmlFileContents = file_get_contents($xmlUrl);
$xmlFileContents = new SimpleXMLElement($xmlFileContents);
$statusCode = $xmlFileContents->statusCode[0];

set_time_limit(180);
while ($statusCode != 200)
{
    $xmlFileContents = file_get_contents($xmlUrl);
    $xmlFileContents = new SimpleXMLElement($xmlFileContents);
    $statusCode = $xmlFileContents->statusCode[0];
    sleep(1);
}

$xmlFileContents = file_get_contents($xmlUrl);
$xmlFile = new SimpleXMLElement($xmlFileContents);
$testId = $xmlFile->data[0]->testId;
$resultFile = fopen("$testId.txt", 'w');
fwrite($resultFile, $xmlFileContents);
echo 'The result was successfully saved';