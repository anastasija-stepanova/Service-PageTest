<?php
class WebPageTestResponseHandler
{
    private const MOBILE_BROWSERS = ['Dulles_MotoG4:Moto G4 - Chrome', 'Dulles_MotoG4:Moto G4 - Chrome Canary',
                                     'Dulles_MotoG4:Moto G4 - Chrome Beta', 'Dulles_MotoG4:Moto G4 - Chrome Dev',
                                     'Dulles_MotoG:Moto G - Chrome', 'Dulles_MotoG:Moto G - Chrome Canary',
                                     'Dulles_MotoG:Moto G - Chrome Beta', 'Dulles_MotoG:Moto G - Chrome Dev',
                                     'Dulles_Linux:Chrome', 'Dulles_Linux:Chrome Beta', 'Dulles_Linux:Chrome Canary',
                                     'Dulles_Linux:Firefox'];

    private const TOTAL_NUM_TEST_RECORD = 2;

    private const FIRST_VIEW = 'firstView';
    private const REPEAT_VIEW = 'firstView';

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
            $tableEntryTestInfo = $this->database->selectOneRow("SELECT * FROM " . DatabaseTable::TEST_INFO .
                                                                " WHERE test_id = ?", [$wptTestId]);

            if ($tableEntryTestInfo && array_key_exists('completed', $response))
            {
                $testInfo[] = $response['completed'];
                $testInfo[] = TestStatus::COMPLETED;
                $testInfo[] = $wptTestId;
                $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO .
                                              " SET completed_time = FROM_UNIXTIME(?), is_completed = ?
                                              WHERE test_id = ?", $testInfo);

                if (array_key_exists('id', $tableEntryTestInfo))
                {
                    $testId = $tableEntryTestInfo['id'];

                    $tableEntryRawData = $this->database->selectOneRow("SELECT * FROM " . DatabaseTable::RAW_DATA .
                                                                       " WHERE test_id = ?", [$testId]);

                    if (!$tableEntryRawData)
                    {
                        $jsonData = json_encode($response);

                        $this->database->executeQuery("INSERT INTO " . DatabaseTable::RAW_DATA .
                                                      " (test_id, json_data) VALUES (?, ?)", [$testId, $jsonData]);
                    }

                    $this->insertIntoAverageResult($response, self::FIRST_VIEW, $testId, ViewType::FIRST);
                    $this->insertIntoAverageResult($response, self::REPEAT_VIEW, $testId, ViewType::REPEAT);
                }
            }
        }
    }

    private function insertIntoAverageResult($data, $wptTypeView, $testId, $typeView)
    {
        if (array_key_exists($wptTypeView, $data['average']))
        {
            $commonTestResultCreator = new CommonTestResultCreator();

            $wptLocation = $this->database->executeQuery("SELECT location FROM " . DatabaseTable::WPT_LOCATION .
                                                          " LEFT JOIN " . DatabaseTable::TEST_INFO .
                                                          " ON " . DatabaseTable::WPT_LOCATION .
                                                          ".id = " . DatabaseTable::TEST_INFO .
                                                          ".location_id WHERE " . DatabaseTable::TEST_INFO .
                                                          ".id = ?", [$testId], PDO::FETCH_COLUMN);

            if (!in_array($wptLocation[0], self::MOBILE_BROWSERS))
            {
                $commonTestResult = $commonTestResultCreator->createFromDesktopBrowser($data['average'][$wptTypeView]);
                $averageResult = $commonTestResult->getAsArray();
            }
            else
            {
                $commonTestResult = $commonTestResultCreator->createFromMobileBrowser($data['average'][$wptTypeView]);
                $averageResult = $commonTestResult->getAsArray();
            }

            $averageResult[] = $testId;
            $averageResult[] = $typeView;
            $recordExists = $this->database->executeQuery("SELECT type_view FROM " . DatabaseTable::AVERAGE_RESULT .
                                                          " WHERE test_id = ?", [$testId]);

            if (count($recordExists) < self::TOTAL_NUM_TEST_RECORD)
            {
                $this->database->executeQuery("INSERT INTO " . DatabaseTable::AVERAGE_RESULT . "
                                              (load_time, ttfb, bytes_out, bytes_out_doc,
                                               bytes_in, bytes_in_doc, connections, requests, requests_doc,
                                               responses_200, responses_404, responses_other, render_time,
                                               fully_loaded, doc_time, dom_elements, title_time,
                                               load_event_start, load_event_end, dom_content_loaded_event_start,
                                               dom_content_loaded_event_end, first_paint, dom_interactive,  dom_loading,
                                               visual_complete, test_id, type_view)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                               ?, ?, ?, ?, ?, ?, ?, ?, ?)", $averageResult);
            }
        }
    }
}