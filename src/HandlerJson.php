<?php
class HandlerJson
{
    private $client;

    public function __construct()
    {
        $this->client = new WebPageTestClient();
    }

    public function handleResponse()
    {
        $response = $this->client->getResult('170705_VG_15YX');

        unset($response['data']['standardDeviation']);

        $database = new Database();
        $json = json_encode($response);
        $json2 = substr($json, 1, 200000); //606187
        $database->dbQuery("INSERT INTO raw_data (json_data) VALUES ('$json2')");
    }
}