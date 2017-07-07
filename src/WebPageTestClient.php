<?php
use GuzzleHttp\Client as Client;

class WebPageTestClient
{
    const BASE_URL = 'http://www.webpagetest.org/';

    const RUNTEST_METHOD_NAME = 'runtest';
    const RESULT_METHOD_NAME = 'jsonResult';
    const STATUS_METHOD_NAME = 'testStatus';

    const HTTP_METHOD = 'GET';

    const RESPONSE_FORMAT = 'json';

    const FILE_EXTENSION = '.php?';

    const NUMBER_RUNS = 1;

    const PARAM_URL = 'url';
    const PARAM_RUNS = 'runs';
    const PARAM_FORMAT = 'f';
    const PARAM_KEY = 'k';
    const PARAM_TEST = 'test';

    private $apiKey;
    private $client;

    public function __construct($apiKey = Config::APY_KEY)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    public function runNewTest($siteUrl)
    {
        $testId = null;

        $params = [
            self::PARAM_URL => $siteUrl,
            self::PARAM_RUNS => self::NUMBER_RUNS,
            self::PARAM_FORMAT => self::RESPONSE_FORMAT,
            self::PARAM_KEY => $this->apiKey
        ];

        $runTestUrl = $this->generateWPTUrl(self::RUNTEST_METHOD_NAME, $params);
        $decodeJsonResponse = $this->sendRequest(self::HTTP_METHOD, $runTestUrl);

        if ($decodeJsonResponse['data']['testId'])
        {
            $testId = $decodeJsonResponse['data']['testId'];
        }

        return $testId;
    }

    public function checkStateTest($testId)
    {
        $params = [
            self::PARAM_FORMAT => self::RESPONSE_FORMAT,
            self::PARAM_TEST => $testId
        ];

        $statusTestUrl = $this->generateWPTUrl(self::STATUS_METHOD_NAME, $params);
        $decodeJsonContent = $this->sendRequest(self::HTTP_METHOD, $statusTestUrl);

        return $decodeJsonContent;
    }

    public function getResult($testId)
    {
        $param = [
            self::PARAM_TEST => $testId
        ];

        $resultTestUrl = $this->generateWPTUrl(self::RESULT_METHOD_NAME, $param);
        $decodeJsonContent = $this->sendRequest(self::HTTP_METHOD, $resultTestUrl);
        $encodeJsonContent = json_encode($decodeJsonContent);

        return $encodeJsonContent;
    }

    private function generateWPTUrl($methodName, $params)
    {
        $wPTUrl = self::BASE_URL . $methodName . self::FILE_EXTENSION . $this->paramsToString($params);

        return $wPTUrl;
    }

    private function paramsToString($params)
    {
        $paramsStr = '';
        $paramsArray = [];

        foreach ($params as $key => $value)
        {
            $paramsArray[] = "$key=$value";
        }

        return $paramsStr.implode('&', $paramsArray);
    }

    private function sendRequest($methodName, $url)
    {
        $response = $this->client->request($methodName, $url);
        $contentResponse = $response->getBody()->getContents();

        $decodeContentResponse = json_decode($contentResponse, true);
        $jsonLastError = json_last_error();

        if ($jsonLastError == JSON_ERROR_NONE)
        {
            return $decodeContentResponse;
        }
        else
        {
            return null;
        }
    }
}