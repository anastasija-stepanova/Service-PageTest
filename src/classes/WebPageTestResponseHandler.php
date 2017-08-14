<?php
class WebPageTestResponseHandler
{
    private const TOTAL_NUM_TEST_RECORD = 2;

    private const FIRST_VIEW = 'firstView';
    private const REPEAT_VIEW = 'repeatView';

    private const BASIC_BROWSER_TYPE = 0;

    private $databaseDataManager;

    public function __construct()
    {
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function handle($response)
    {
        if ($response && array_key_exists('id', $response))
        {
            $wptTestId = $response['id'];
            $recordTestInfo = $this->databaseDataManager->getTableEntry(DatabaseTable::TEST_INFO, $wptTestId);

            if ($recordTestInfo && array_key_exists('completed', $response))
            {
                $this->databaseDataManager->updateTestInfoCompletedTime($response['completed'], $wptTestId);

                if (array_key_exists('id', $recordTestInfo))
                {
                    $testId = $recordTestInfo['id'];

                    $recordRawData = $this->databaseDataManager->getTableEntry(DatabaseTable::RAW_DATA, $testId);

                    if (!$recordRawData)
                    {
                        $jsonData = json_encode($response);

                        $this->databaseDataManager->saveRawData($testId, $jsonData);
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

            $typeBrowser = $this->databaseDataManager->getBrowserType($testId);

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
            $recordExists = $this->databaseDataManager->testIsExists($testId);

            if (count($recordExists) < self::TOTAL_NUM_TEST_RECORD)
            {
                $this->databaseDataManager->saveAverageResult($averageResult);
            }
        }
    }
}