<?php
class WebPageTestResponseHandler
{
    private const BASIC_BROWSER_TYPE = 0;

    private $databaseDataManager;

    public function __construct()
    {
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function handle(array $response): void
    {
        if ($response && array_key_exists(WptKeys::ID, $response))
        {
            $wptTestId = $response[WptKeys::ID];
            $recordTestInfo = $this->databaseDataManager->getTableRowByTestId(DatabaseTable::TEST_INFO, $wptTestId);

            if ($recordTestInfo && array_key_exists(WptKeys::COMPLETED, $response))
            {
                $this->databaseDataManager->updateTestInfoCompletedTime($response[WptKeys::COMPLETED], $wptTestId);

                if (array_key_exists(WptKeys::ID, $recordTestInfo))
                {
                    $testId = $recordTestInfo[WptKeys::ID];

                    $this->saveRawData($response, $testId);

                    $this->insertIntoAverageResult($response, WptKeys::FIRST_VIEW, $testId, ViewType::FIRST);
                    $this->insertIntoAverageResult($response, WptKeys::REPEAT_VIEW, $testId, ViewType::REPEAT);
                }
            }
        }
    }

    private function saveRawData(array $response, int $testId): void
    {
        $recordRawData = $this->databaseDataManager->getTableRowByTestId(DatabaseTable::RAW_DATA, $testId);

        if (!$recordRawData)
        {
            $jsonData = json_encode($response);

            $this->databaseDataManager->saveRawData($testId, $jsonData);
        }
    }

    private function insertIntoAverageResult(array $data, string $wptTypeView, int $testId, int $typeView): void
    {
        if (array_key_exists($wptTypeView, $data[WptKeys::AVERAGE]))
        {
            $commonTestResultCreator = new CommonTestResultCreator();

            $typeBrowser = $this->databaseDataManager->getBrowserType($testId);

            if ($typeBrowser == self::BASIC_BROWSER_TYPE)
            {
                $commonTestResult = $commonTestResultCreator->createFromDesktopBrowser($data[WptKeys::AVERAGE][$wptTypeView]);
                $averageResult = $commonTestResult->getAsArray();
            }
            else
            {
                $commonTestResult = $commonTestResultCreator->createFromMobileBrowser($data[WptKeys::AVERAGE][$wptTypeView]);
                $averageResult = $commonTestResult->getAsArray();
            }

            $averageResult[] = $testId;
            $averageResult[] = $typeView;
            $averageResult[] = $data[WptKeys::COMPLETED];
            $recordExists = $this->databaseDataManager->doesTestExists($testId);

            if ($recordExists)
            {
                $this->databaseDataManager->saveAverageResult($averageResult);
            }
        }
    }
}