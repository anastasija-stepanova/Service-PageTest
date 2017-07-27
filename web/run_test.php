<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$users = $database->executeQuery("SELECT * FROM " . DatabaseTable::USER);
$usersArray = generateDataArray($users, 'id');

$urls = $database->executeQuery("SELECT url FROM " . DatabaseTable::USER_URL . " WHERE user_id = ?", [Config::DEFAULT_USER_ID]);
$urlsArray = generateDataArray($urls, 'url');

$userLocations = $database->executeQuery("SELECT * FROM user_location LEFT JOIN wpt_location USING(id)");
$locationsArray = generateDataArray($userLocations, 'location');

$client = new WebPageTestClient();

$testIdsArray = [];
for ($i = 0; $i < count($urlsArray); $i++)
{
    for ($j = 0; $j < count($locationsArray); $j++)
    {
        $wptTestId = $client->runNewTest($urlsArray[$i], $locationsArray[$j]);
        $database->executeQuery("INSERT INTO " . DatabaseTable::TEST_INFO . " (user_id, test_id)
                                 VALUES (?, ?)", [Config::DEFAULT_USER_ID, $wptTestId]);

        $dataArray = $database->selectOneRow("SELECT id FROM " . DatabaseTable::TEST_INFO . " WHERE test_id = ?", [$wptTestId]);

        if (array_key_exists('id', $dataArray))
        {
            $testId = $dataArray['id'];
            $testIdsArray[] = $testId;
            print_r($testIdsArray);
        }
    }
}

function generateDataArray($responseData, $index)
{
    $dataArray = [];
    for ($i = 0; $i < count($responseData); $i++)
    {
        $item = $responseData[$i][$index];
        $dataArray[] = $item;
    }

    return $dataArray;
}