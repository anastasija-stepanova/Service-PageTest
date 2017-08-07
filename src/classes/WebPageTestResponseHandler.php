<?php
class WebPageTestResponseHandler
{
    private const TOTAL_NUM_TEST_RECORD = 2;

    private const FIRST_VIEW = 'firstView';
    private const REPEAT_VIEW = 'repeatView';

    private const BASIC_BROWSER_TYPE = 0;

    private $database;
    private $databaseDataProvider;

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
        $this->databaseDataProvider = new DatabaseDataProvider();
    }

    public function handle($response)
    {
        if ($response && array_key_exists('id', $response))
        {
            $wptTestId = $response['id'];
            $recordTestInfo = $this->databaseDataProvider->getTableEntry(DatabaseTable::TEST_INFO, $wptTestId);

            if ($recordTestInfo && array_key_exists('completed', $response))
            {
                $testInfo[] = $response['completed'];
                $testInfo[] = TestStatus::COMPLETED;
                $testInfo[] = $wptTestId;
                $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO .
                                              " SET completed_time = FROM_UNIXTIME(?), test_status = ?
                                              WHERE test_id = ?", $testInfo);

                if (array_key_exists('id', $recordTestInfo))
                {
                    $testId = $recordTestInfo['id'];

                    $recordRawData = $this->databaseDataProvider->getTableEntry(DatabaseTable::RAW_DATA, $testId);

                    if (!$recordRawData)
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

            $typeBrowser = $this->databaseDataProvider->getBrowserType($testId);

            if ($typeBrowser == self::BASIC_BROWSER_TYPE)
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
            $averageResult[] = $data['completed'];
            $recordExists = $this->databaseDataProvider->checkExistenceRecord($testId);

            if (count($recordExists) < self::TOTAL_NUM_TEST_RECORD)
            {
                $this->database->executeQuery("INSERT INTO " . DatabaseTable::AVERAGE_RESULT . "
                                              (load_time, ttfb, bytes_out, bytes_out_doc,
                                               bytes_in, bytes_in_doc, connections, requests, requests_doc,
                                               responses_200, responses_404, responses_other, render_time,
                                               fully_loaded, doc_time, dom_elements, title_time,
                                               load_event_start, load_event_end, dom_content_loaded_event_start,
                                               dom_content_loaded_event_end, first_paint, dom_interactive,  dom_loading,
                                               visual_complete, test_id, type_view, completed_time)
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                               ?, ?, ?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?))", $averageResult);
            }
        }
    }
}