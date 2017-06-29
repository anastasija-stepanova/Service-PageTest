<?php
use GuzzleHttp\Client as Client;

require_once '../vendor/autoload.php';

class classClient
{
    const HTTP_METHOD = 'POST';
    const RUNTEST_URL = 'http://www.webpagetest.org/runtest.php';
    private $client;
    private $xmlResponseElement;
    private $testId;

    public function sendRequest($siteUrl, $apiKey)
    {
        $this->client = new Client();
        $response = $this->client->request($this::HTTP_METHOD, "http://www.webpagetest.org/runtest.php?url=$siteUrl&runs=1&f=xml&k=$apiKey");
        $xmlResponse = $response->getBody()->getContents();
        $this->xmlResponseElement = new SimpleXMLElement($xmlResponse);
        if (isset($this->xmlResponseElement->data[0]))
        {
            $this->testId = $this->xmlResponseElement->data[0]->testId;
            return $this->testId;
        }
    }
//
//    public function getResponse()
//    {
//        $jsonUrl = $this->xmlResponseElement->data[0]->jsonUrl;
//        $jsonFileContents = file_get_contents($jsonUrl);
//        $array = json_decode($jsonFileContents);
//        return $array;
//    }
}