<?php
class WebPageTestResponseHandler
{
    private const TEST_INFO_KEYS = ['location', 'from', 'completed', 'tester'];
    private const DEFAULT_TEST_RESULT_KEYS = ['loadTime', 'TTFB', 'bytesOut', 'bytesOutDoc', 'bytesIn', 'bytesInDoc', 'connections',
        'requests', 'requestsDoc', 'responses_200', 'responses_404', 'responses_other', 'render', 'fullyLoaded', 'docTime',
        'image_total', 'base_page_redirects', 'domElements', 'titleTime', 'loadEventStart', 'loadEventEnd',
        'domContentLoadedEventStart', 'domContentLoadedEventEnd', 'firstPaint', 'domInteractive', 'domLoading',
        'visualComplete', 'SpeedIndex', 'certificate_bytes'];

    private const CHROME_TEST_RESULT_KEYS = ['loadTime', 'TTFB', 'bytesOut', 'bytesOutDoc', 'bytesIn', 'bytesInDoc',
        'connections', 'requests', 'requestsDoc', 'responses_200', 'responses_404', 'responses_other', 'fullyLoaded',
        'docTime', 'image_total', 'final_base_page_request', 'domElements', 'loadEventStart', 'loadEventEnd',
        'domContentLoadedEventStart', 'domContentLoadedEventEnd', 'firstPaint', 'domInteractive', 'testStartOffset',
        'chromeUserTiming.fetchStart', 'chromeUserTiming.redirectStart', 'chromeUserTiming.redirectEnd',
        'chromeUserTiming.unloadEventStart', 'chromeUserTiming.unloadEventEnd', 'chromeUserTiming.domLoading',
        'chromeUserTiming.responseEnd', 'chromeUserTiming.firstLayout', 'chromeUserTiming.firstContentfulPaint',
        'chromeUserTiming.firstTextPaint', 'chromeUserTiming.firstImagePaint', 'chromeUserTiming.firstMeaningfulPaint',
        'chromeUserTiming.domComplete'];

    private const OTHER_BROWSER_TEST_RESULT_KEYS = ['loadTime', 'TTFB', 'bytesOut', 'bytesOutDoc', 'bytesIn', 'bytesInDoc',
        'render', 'fullyLoaded', 'docTime', 'loadEventStart', 'loadEventEnd', 'domContentLoadedEventStart',
        'domContentLoadedEventEnd', 'firstPaint', 'domInteractive', 'domLoading', 'pcapBytesIn', 'pcapBytesInDup',
        'pcapBytesOut', 'SpeedIndex', 'visualComplete'];

    private const TOTAL_NUM_TEST_RECORD = 2;

    private const FIRST_VIEW = 'firstView';
    private const REPEAT_VIEW = 'firstView';

    private $database;

    public function __construct()
    {
        return $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function handle($response)
    {
        if ($response && array_key_exists('id', $response))
        {
            $wptTestId = $response['id'];
            $databaseRecord = $this->database->selectOneRow("SELECT * FROM " . DatabaseTable::TEST_INFO .
                                                            " WHERE test_id = ?", [$wptTestId]);

            if ($databaseRecord)
            {
                $testInfo = $this->generateTestDataArray($response, self::TEST_INFO_KEYS);
                $testInfo[] = $wptTestId;
                $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO .
                                              " SET location = ?, from_place = ?, completed_time = FROM_UNIXTIME(?), tester = ?
                                              WHERE test_id = ?", $testInfo);

                if (array_key_exists('id', $databaseRecord))
                {
                    $testId = $databaseRecord['id'];
                    $this->insertIntoAverageResult($response, self::FIRST_VIEW, $testId, ViewType::FIRST, DatabaseTable::DEFAULT_AVERAGE_RESULT, self::DEFAULT_TEST_RESULT_KEYS);
                    $this->insertIntoAverageResult($response, self::REPEAT_VIEW, $testId, ViewType::REPEAT, DatabaseTable::DEFAULT_AVERAGE_RESULT, self::DEFAULT_TEST_RESULT_KEYS);
                    $this->insertIntoAverageResult($response, self::FIRST_VIEW, $testId, ViewType::FIRST, DatabaseTable::CHROME_AVERAGE_RESULT, self::CHROME_TEST_RESULT_KEYS);
                    $this->insertIntoAverageResult($response, self::REPEAT_VIEW, $testId, ViewType::REPEAT, DatabaseTable::CHROME_AVERAGE_RESULT, self::CHROME_TEST_RESULT_KEYS);
                    $this->insertIntoAverageResult($response, self::FIRST_VIEW, $testId, ViewType::FIRST, DatabaseTable::OTHER_BROWSER_AVERAGE_RESULT, self::OTHER_BROWSER_TEST_RESULT_KEYS);
                    $this->insertIntoAverageResult($response, self::REPEAT_VIEW, $testId, ViewType::REPEAT, DatabaseTable::OTHER_BROWSER_AVERAGE_RESULT, self::OTHER_BROWSER_TEST_RESULT_KEYS);
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

    private function insertIntoAverageResult($data, $wptTypeView, $testId, $typeView, $table, $keys)
    {
        if (array_key_exists($wptTypeView, $data['average']))
        {
            $averageResult = $this->generateTestDataArray($data['average'][$wptTypeView], $keys);
            $averageResult[] = $testId;
            $averageResult[] = $typeView;
            $recordExists = $this->database->executeQuery("SELECT type_view FROM " . $table .
                                                          " WHERE test_id = ?", [$testId]);

            if (count($recordExists) < self::TOTAL_NUM_TEST_RECORD)
            {
                $this->database->executeQuery("INSERT INTO " . DatabaseTable::OTHER_BROWSER_AVERAGE_RESULT . "
                                              (load_time, ttfb, bytes_out, bytes_out_doc, bytes_in, bytes_in_doc, render,
                                               fully_loaded, doc_time, load_event_start, load_event_end,
                                               dom_content_loaded_event_start,  dom_content_loaded_event_end,
                                               first_paint, dom_interactive,  dom_loading, pcap_bytes_in, pcap_bytes_in_dup, 
                                               pcap_bytes_out, speed_index, visual_complete, test_id, type_view)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                               ?, ?, ?, ?, ?)", $averageResult);

                $this->database->executeQuery("INSERT INTO " . DatabaseTable::CHROME_AVERAGE_RESULT . "
                                              (load_time, ttfb, bytes_out, bytes_out_doc,
                                               bytes_in, bytes_in_doc, connections, requests, requests_doc,
                                               responses_200, responses_404, responses_other, fully_loaded, doc_time, 
                                               image_total, final_base_page_request, dom_elements, title_time,  
                                               load_event_start, load_event_end, dom_content_loaded_event_start,  
                                               dom_content_loaded_event_end, first_paint, dom_interactive, test_start_offset, 
                                               chrome_user_timing_fetch_start, chrome_user_timing_redirect_start, 
                                               chrome_user_timing_redirect_end, chrome_user_timing_unload_event_start, 
                                               chrome_user_timing_unload_event_end, chrome_user_timing_dom_loading, 
                                               chrome_user_timing_response_end, chrome_user_timing_first_layout, 
                                               chrome_user_timing_first_contentful_paint, chrome_user_timing_first_text_paint, 
                                               chrome_user_timing_first_image_paint, chrome_user_timing_first_meaningful_paint, 
                                               chrome_user_timing_dom_complete, test_id, type_view)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                               ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $averageResult);

                $this->database->executeQuery("INSERT INTO " . DatabaseTable::DEFAULT_AVERAGE_RESULT . "
                                              (load_time, ttfb, bytes_out, bytes_out_doc,
                                               bytes_in, bytes_in_doc, connections, requests, requests_doc,
                                               responses_200, responses_404, responses_other, render_time,
                                               fully_loaded, doc_time, image_total, base_page_redirects,
                                               dom_elements, title_time, load_event_start, load_event_end,
                                               dom_content_loaded_event_start, dom_content_loaded_event_end,
                                               first_paint, dom_interactive,  dom_loading, visual_complete,
                                               speed_index, certificate_bytes, test_id, type_view)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                               ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $averageResult);
            }
        }
    }
}