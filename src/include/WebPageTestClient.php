<?php
use GuzzleHttp\Client as Client;

require_once __DIR__ . '../../vendor/autoload.php';

class WebPageTestClient
{
    const BASE_URL = 'http://www.webpagetest.org/';
    const RUNTEST_METHOD_NAME = 'runtest';
    const RESULT_METHOD_NAME = 'jsonResult';
    const HTTP_METHOD = 'POST';
    const RESPONSE_FORMAT = 'json';
    const FILE_EXTENSION = '.php?';
    const RESPONSE_TIMEOUT = 180;

    private $apiKey;
    private $client;

    public function __construct($apiKey)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    private function generateRunTestUrl($siteUrl)
    {
        $params = [
            'url' => $siteUrl,
            'runs' => 1,
            'f' => 'json'
        ];
        $params['k'] = $this->apiKey;

        $runTestUrl = self::BASE_URL . self::RUNTEST_METHOD_NAME . self::FILE_EXTENSION;

        $paramsStr = '';
        foreach ($params as $key => $value)
        {
            $paramsStr .= "$key=$value" . '&';
        }

        $runTestUrl .= $paramsStr;
        return $runTestUrl;
    }

    private function generateResultTestUrl($testId)
    {
        $params = [
            'test' => $testId
        ];

        $resultTestUrl = self::BASE_URL . self::RESULT_METHOD_NAME  . self::FILE_EXTENSION;

        $paramsStr = '';
        foreach ($params as $key => $value)
        {
            $paramsStr .= "$key=$value";
        }

        $resultTestUrl .= $paramsStr;
        return $resultTestUrl;
    }

    private function getJsonContent($testId)
    {
        $resultUrl = $this->generateResultTestUrl($testId);
        $jsonContent = file_get_contents($resultUrl);
        $decodeJsonContent = json_decode($jsonContent);
        return $decodeJsonContent;
    }

    private function deleteBlockStdDev($testId)
    {
        $decodeJsonContent = $this->getJsonContent($testId)->data;
        $blockRuns = $decodeJsonContent->runs;
        $blockAverage = $decodeJsonContent->average;
        $blockMedian = $decodeJsonContent->median;
        $newJsonContent = [];
        array_push($newJsonContent, $blockRuns);
        array_push($newJsonContent, $blockAverage);
        array_push($newJsonContent, $blockMedian);
        return $newJsonContent;
    }

    public function runNewTest($siteUrl)
    {
        $webPageTestUrl = $this->generateRunTestUrl($siteUrl);
        $response = $this->client->request(self::HTTP_METHOD, $webPageTestUrl);
        $jsonResponse = $response->getBody()->getContents();
        $decodeJsonResponse = json_decode($jsonResponse);
        $testId = $decodeJsonResponse->data->testId;

        return $testId;
    }

    public function checkStateTest($testId)
    {
        $decodeJsonContent = $this->getJsonContent($testId);
        $statusCode = $decodeJsonContent->data->statusCode;

        if (!array_key_exists($statusCode, $decodeJsonContent))
        {
            sleep(self::RESPONSE_TIMEOUT);
        }

        return $testId;
    }

    public function getResult($testId)
    {
        $decodeJsonContent = $this->deleteBlockStdDev($testId);
        $encodeJsonContent = json_encode($decodeJsonContent);
        return $encodeJsonContent;
    }

}