<?php
class WebPageTestResponseHandler
{
    private const TOTAL_NUM_TEST_RECORD = 2;

    private const FIRST_VIEW = 'firstView';
    private const REPEAT_VIEW = 'repeatView';

    private const BASIC_BROWSER_TYPE = 0;

    private $databaseDataProvider;

    public function __construct()
    {
        $this->databaseDataProvider = new DatabaseDataManager();
    }

    public function handle($response)
    {
        if ($response && array_key_exists('id', $response))
        {
            $wptTestId = $response['id'];
            $recordTestInfo = $this->databaseDataProvider->getTableEntry(DatabaseTable::TEST_INFO, $wptTestId);

            if ($recordTestInfo && array_key_exists('completed', $response))
            {
                $this->databaseDataProvider->updateTestInfoCompletedTime($response['completed'], $wptTestId);

                if (array_key_exists('id', $recordTestInfo))
                {
                    $testId = $recordTestInfo['id'];

                    $recordRawData = $this->databaseDataProvider->getTableEntry(DatabaseTable::RAW_DATA, $testId);

                    if (!$recordRawData)
                    {
                        $jsonData = json_encode($response);

                        $this->databaseDataProvider->saveRawData($testId, $jsonData);
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
            $recordExists = $this->databaseDataProvider->testIsExists($testId);

            if (count($recordExists) < self::TOTAL_NUM_TEST_RECORD)
            {
                $this->databaseDataProvider->saveAverageResult($averageResult);
            }
        }
    }
}