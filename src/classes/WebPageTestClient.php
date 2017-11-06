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

    public function __construct(string $apiKey)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    public function runNewTest(string $siteUrl, string $location): string
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

    public function checkTestState(string $testId): array
    {
        $params = [
            self::PARAM_FORMAT => self::RESPONSE_FORMAT,
            self::PARAM_TEST => $testId
        ];

        $statusTestUrl = $this->generateWptUrl(self::STATUS_METHOD_NAME, $params);
        return $this->sendRequest(self::HTTP_METHOD, $statusTestUrl);
    }

    public function getResult(string $testId): array
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

    private function generateWptUrl(string $methodName, array $params): string
    {
        $wptUrl = self::BASE_URL . $methodName . self::FILE_EXTENSION . $this->generateGetParams($params);

        return $wptUrl;
    }

    private function generateGetParams(array $params): string
    {
        $paramsArray = [];

        foreach ($params as $key => $value)
        {
            $paramsArray[] = "$key=$value";
        }

        return '?' . implode('&', $paramsArray);
    }

    private function sendRequest(string $methodName, string $url): array
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