<?php
class WebPageTestResponseHandler
{
    private $database;
    private $data;

    private $keysTestInfo = ['location', 'from', 'completed', 'testerDNS'];

    private $keysTestResult = ['loadTime', 'TTFB', 'bytesOut', 'bytesOutDoc', 'bytesIn', 'bytesInDoc', 'connections',
        'requests', 'requestsDoc', 'responses_200', 'responses_404', 'responses_other', 'render', 'fullyLoaded', 'docTime',
        'image_total', 'base_page_redirects', 'domElements', 'titleTime', 'loadEventStart', 'loadEventEnd',
        'domContentLoadedEventStart', 'domContentLoadedEventEnd', 'firstPaint', 'domInteractive', 'domLoading',
        'visualComplete', 'SpeedIndex', 'certificate_bytes'];

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function handle($response)
    {
        if ($response && array_key_exists('data', $response))
        {
            $this->data = $response['data'];

            $this->saveDataToDb($this->data);
        }
    }

    private function saveDataToDb($data)
    {
        if ($data && array_key_exists('id', $data))
        {
            $wptTestId = $data['id'];
            echo $wptTestId;

            $testInfo = $this->generateTestDataArray($data, $this->keysTestInfo);
            $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO . " SET url_id = ?, location = ?, from_place = ?, tester_dns = ?) 
                                           WHERE test_id = ?", [$testInfo, $wptTestId]);
        }
    }

    private function getArrayValue($array, $key)
    {
        if (array_key_exists($key, $array))
        {
            $value = $array[$key];
        }
        else
        {
            $value = '';
        }

        return $value;
    }

    private function generateTestDataArray($data, $keys)
    {
        $dataArray = [];

        foreach ($keys as $key)
        {
            if (array_key_exists($key, $data))
            {
                $this->getArrayValue($data, $key);
            }
        }

        return $dataArray;
    }
}