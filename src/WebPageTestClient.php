<?php
use GuzzleHttp\Client as Client;

class WebPageTestClient
{
    const BASE_URL = 'http://www.webpagetest.org/';

    const RUNTEST_METHOD_NAME = 'runtest';
    const RESULT_METHOD_NAME = 'jsonResult';

    const HTTP_METHOD = 'GET';

    const RESPONSE_FORMAT = 'json';
    const SUCCESSFUL_STATUS = 200;

    const FILE_EXTENSION = '.php?';

    private $apiKey;
    private $client;

    public function __construct($apiKey = Config::APY_KEY)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    public function runNewTest($siteUrl)
    {
        $params = [
            'url' => $siteUrl,
            'runs' => 1,
            'f' => 'json'
        ];
        $params['k'] = $this->apiKey;

        $runTestUrl = self::BASE_URL . self::RUNTEST_METHOD_NAME . self::FILE_EXTENSION . $this->paramsToString($params);

        $decodeJsonResponse = $this->sendRequest(self::HTTP_METHOD, $runTestUrl);
        $testId = $decodeJsonResponse['data']['testId'];

        return $testId;
    }

    public function checkStateTest($testId)
    {
        $resultTestUrl = $resultTestUrl = $this->generateResultUrl($testId);

        $decodeJsonContent = $this->sendRequest(self::HTTP_METHOD, $resultTestUrl);
        $statusCode = $decodeJsonContent['data']['statusCode'];

        if ($statusCode != self::SUCCESSFUL_STATUS)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function getResult($testId)
    {
        $resultTestUrl = $this->generateResultUrl($testId);

        $decodeJsonContent = $this->sendRequest(self::HTTP_METHOD, $resultTestUrl);

        return $decodeJsonContent;
    }

    private function generateResultUrl($testId)
    {
        $params = [
            'test' => $testId
        ];

        $resultTestUrl = self::BASE_URL . self::RESULT_METHOD_NAME . self::FILE_EXTENSION . $this->paramsToString($params);

        return $resultTestUrl;
    }

    private function paramsToString($params)
    {
        $paramsStr = '';
        foreach ($params as $key => $value)
        {
            $paramsStr .= "$key=$value&";
        }

        return $paramsStr;
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