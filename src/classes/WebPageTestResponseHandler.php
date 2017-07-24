<?php
class WebPageTestResponseHandler
{
    const TEST_INFO_KEYS = ['location', 'from', 'completed', 'testerDNS'];
    const TEST_RESULT_KEYS = ['loadTime', 'TTFB', 'bytesOut', 'bytesOutDoc', 'bytesIn', 'bytesInDoc', 'connections',
        'requests', 'requestsDoc', 'responses_200', 'responses_404', 'responses_other', 'render', 'fullyLoaded', 'docTime',
        'image_total', 'base_page_redirects', 'domElements', 'titleTime', 'loadEventStart', 'loadEventEnd',
        'domContentLoadedEventStart', 'domContentLoadedEventEnd', 'firstPaint', 'domInteractive', 'domLoading',
        'visualComplete', 'SpeedIndex', 'certificate_bytes'];

    const TOTAL_NUM_TEST_RECORD = 2;

    private $database;

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function handle($response)
    {
        if ($response && array_key_exists('id', $response))
        {
            $wptTestId = $response['id'];
            $testInfo = $this->generateTestDataArray($response, self::TEST_INFO_KEYS);
            $testInfo[] = $wptTestId;
            $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO .
                                          " SET location = ?, from_place = ?, completed_time = FROM_UNIXTIME(?), tester_dns = ? 
                                          WHERE test_id = ?", $testInfo);

            $dataArray = $this->database->selectOneRowDatabase("SELECT id FROM " . DatabaseTable::TEST_INFO .
                                                               " WHERE test_id = ?", [$wptTestId]);

            if (array_key_exists('id', $dataArray))
            {
                $testId = $dataArray['id'];

                if (array_key_exists('average', $response))
                {
                    $this->insertIntoAverageResult($response, 'firstView', $testId, ViewTypeConfig::FIRST_VIEW);
                    $this->insertIntoAverageResult($response, 'repeatView', $testId, ViewTypeConfig::REPEAT_VIEW);
                }
            }
        }
    }

    private function generateTestDataArray($data, $keys)
    {
        $arrayValues = [];

        foreach ($keys as $key)
        {
            if (array_key_exists($key, $data))
            {
                $arrayValues[] = $data[$key];
            }
        }

        return $arrayValues;
    }

    private function insertIntoAverageResult($data, $wptTypeView, $testId, $typeView)
    {
        if (array_key_exists($wptTypeView, $data['average']))
        {
            $averageResult = $this->generateTestDataArray($data['average'][$wptTypeView], self::TEST_RESULT_KEYS);
            $averageResult[] = $testId;
            $averageResult[] = $typeView;
            $recordExists = $this->database->executeQuery("SELECT type_view FROM " . DatabaseTable::AVERAGE_RESULT .
                                                          " WHERE test_id = ?", [$testId]);

            if (count($recordExists) != self::TOTAL_NUM_TEST_RECORD)
            {
                $this->database->executeQuery("INSERT INTO " . DatabaseTable::AVERAGE_RESULT . "
                                          (load_time, ttfb, bytes_out, bytes_out_doc,
                                          bytes_in, bytes_in_doc, connections, requests, requests_doc,
                                          responses_200, responses_404, responses_other, render_time,
                                          fully_loaded, doc_time,  image_total, base_page_redirects,
                                          dom_elements, title_time,  load_event_start, load_event_end,
                                          dom_content_loaded_event_start,  dom_content_loaded_event_end,
                                          first_paint, dom_interactive,  dom_loading, visual_complete,
                                          speed_index, certificate_bytes, test_id, type_view)
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                          ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $averageResult);
            }
        }
    }
}