<?php
use GuzzleHttp\Client as Client;

class WebPageTestClient
{
    const BASE_URL = 'http://www.webpagetest.org/';

    const RUNTEST_METHOD_NAME = 'runtest';
    const RESULT_METHOD_NAME = 'jsonResult';
    const STATUS_METHOD_NAME = 'testStatus';
    const LOCATIONS_METHOD_NAME = 'getLocations';

    const HTTP_METHOD = 'GET';

    const RESPONSE_FORMAT = 'json';

    const FILE_EXTENSION = '.php';

    const NUMBER_RUNS = 1;

    const PARAM_URL = 'url';
    const PARAM_RUNS = 'runs';
    const PARAM_FORMAT = 'f';
    const PARAM_KEY = 'k';
    const PARAM_TEST = 'test';
    const PARAM_LOCATION = 'location';

    private $apiKey;
    private $client;

    public function __construct($apiKey = 'A.7a90c9f8293c2f09d0ea68c78e19c1f6')
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    public function runNewTest($siteUrl, $location)
    {
        $testId = null;

        $params = [
            self::PARAM_URL => $siteUrl,
            self::PARAM_RUNS => self::NUMBER_RUNS,
            self::PARAM_LOCATION => $location,
            self::PARAM_FORMAT => self::RESPONSE_FORMAT,
            self::PARAM_KEY => $this->apiKey
        ];

        $runTestUrl = $this->generateWptUrl(self::RUNTEST_METHOD_NAME, $params);
        $decodeJsonResponse = $this->sendRequest(self::HTTP_METHOD, $runTestUrl);

        if ($decodeJsonResponse != null)
        {
            if (array_key_exists('data', $decodeJsonResponse) && array_key_exists('testId', $decodeJsonResponse['data']))
            {
                $testId = $decodeJsonResponse['data']['testId'];
            }
        }

        return $testId;
    }

    public function checkTestState($testId)
    {
        $params = [
            self::PARAM_FORMAT => self::RESPONSE_FORMAT,
            self::PARAM_TEST => $testId
        ];

        $statusTestUrl = $this->generateWptUrl(self::STATUS_METHOD_NAME, $params);
        return $this->sendRequest(self::HTTP_METHOD, $statusTestUrl);
    }

    public function getResult($testId)
    {
        $arrayTestResults = null;

        $param = [
            self::PARAM_TEST => $testId
        ];

        $resultTestUrl = $this->generateWptUrl(self::RESULT_METHOD_NAME, $param);
        $decodeJsonResponse =  $this->sendRequest(self::HTTP_METHOD, $resultTestUrl);

        if ($decodeJsonResponse != null && array_key_exists('data', $decodeJsonResponse));
        {
            $arrayTestResults = $decodeJsonResponse['data'];
        }

        return $arrayTestResults;
    }

    public function getLocations()
    {
        $param = [
            self::PARAM_FORMAT => self::RESPONSE_FORMAT,
            self::PARAM_KEY => $this->apiKey
        ];

        $locationUrl = $this->generateWptUrl(self::LOCATIONS_METHOD_NAME, $param);
        $decodeJsonResponse = $this->sendRequest(self::HTTP_METHOD, $locationUrl);

        if ($decodeJsonResponse != null && array_key_exists('data', $decodeJsonResponse));
        {
            $arrayLocations = $decodeJsonResponse['data'];
        }

        return $arrayLocations;
    }

    private function generateWptUrl($methodName, $params)
    {
        $wptUrl = self::BASE_URL . $methodName . self::FILE_EXTENSION . $this->generateGetParams($params);

        return $wptUrl;
    }

    private function generateGetParams($params)
    {
        $paramsArray = [];

        foreach ($params as $key => $value)
        {
            $paramsArray[] = "$key=$value";
        }

        return '?' . implode('&', $paramsArray);
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

        return null;
    }
}