<?php
class WebPageTestResponseHandler
{
    private $database;

    private $testInfoKeys = ['location', 'from', 'testerDNS'];
    private $testResultKeys = ['loadTime', 'TTFB', 'bytesOut', 'bytesOutDoc', 'bytesIn', 'bytesInDoc', 'connections',
        'requests', 'requestsDoc', 'responses_200', 'responses_404', 'responses_other', 'render', 'fullyLoaded', 'docTime',
        'image_total', 'base_page_redirects', 'domElements', 'titleTime', 'loadEventStart', 'loadEventEnd',
        'domContentLoadedEventStart', 'domContentLoadedEventEnd', 'firstPaint', 'domInteractive', 'domLoading',
        'visualComplete', 'SpeedIndex', 'certificate_bytes'];

    const FIRST_VIEW = 1;
    const REPEAT_VIEW = 2;

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function handle($response)
    {
        $this->saveDataToDb($response);
    }

    private function saveDataToDb($data)
    {
        if ($data && array_key_exists('id', $data))
        {
            $wptTestId = $data['id'];
            $testInfo = $this->generateTestDataArray($data, $this->testInfoKeys);
            $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO .
                                          " SET location = ?, from_place = ?, tester_dns = ? 
                                          WHERE test_id = '$wptTestId'", $testInfo);

            $dataArray = $this->database->executeQuery("SELECT id FROM " . DatabaseTable::TEST_INFO . " WHERE test_id = ?", [$wptTestId]);
            if (array_key_exists(0, $dataArray) && array_key_exists('id', $dataArray[0]))
            {
                $testId = $dataArray[0]['id'];
                if (array_key_exists('average', $data))
                {
                    if (array_key_exists('firstView', $data['average']))
                    {
                        $averageResultFirst = $this->generateTestDataArray($data['average']['firstView'], $this->testResultKeys);
                        $averageResultFirst[] = $testId;
                        $averageResultFirst[] = self::FIRST_VIEW;
                        $recordExists = $this->database->executeQuery("SELECT test_id FROM " . DatabaseTable::AVERAGE_RESULT .
                                                                      " WHERE type_view = ?", [self::FIRST_VIEW]);
                        if (!array_key_exists(0, $recordExists))
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
                                                           ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $averageResultFirst);
                        }
                    }

                    if (array_key_exists('repeatView', $data['average']))
                    {
                        $averageResultRepeat = $this->generateTestDataArray($data['average']['repeatView'], $this->testResultKeys);
                        $averageResultRepeat[] = $testId;
                        $averageResultRepeat[] = self::REPEAT_VIEW;
                        $recordExists = $this->database->executeQuery("SELECT test_id FROM " . DatabaseTable::AVERAGE_RESULT .
                                                                      " WHERE type_view = ?", [self::REPEAT_VIEW]);
                        if (!array_key_exists(0, $recordExists))
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
                                                           ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $averageResultRepeat);
                        }
                    }
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
}