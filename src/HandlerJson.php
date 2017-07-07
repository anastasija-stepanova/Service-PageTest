<?php
class HandlerJson
{
    private $client;

    public function __construct()
    {
        $this->client = new WebPageTestClient();
    }

    public function handleResponse($testId)
    {
        $response = $this->client->getResult($testId);

        if ($response['data'] && $response['data']['standardDeviation'])
        {
            unset($response['data']['standardDeviation']);
        }

        $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
        $json = json_encode($response);//606187
        $database->executeQuery("INSERT INTO raw_data (json_data) VALUES ('{$json}')");
    }
}