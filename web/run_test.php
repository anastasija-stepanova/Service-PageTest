<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$usersId = $database->executeQuery("SELECT id FROM " . DatabaseTable::USER, [], PDO::FETCH_COLUMN);

for ($i = 0; $i < count($usersId); $i++)
{
    $userUrls = $database->executeQuery("SELECT url FROM " . DatabaseTable::USER_URL .
                                        " WHERE user_id = ?", [Config::DEFAULT_USER_ID], PDO::FETCH_COLUMN);

    $userLocations = $database->executeQuery("SELECT * FROM " . DatabaseTable::USER_LOCATION .
                                             " LEFT JOIN " .DatabaseTable::WPT_LOCATION .
                                             " ON " . DatabaseTable::USER_LOCATION . ". wpt_location_id = "
                                              . DatabaseTable::WPT_LOCATION . ".id");

    $apiKey = $database->executeQuery("SELECT api_key FROM " . DatabaseTable::USER .
                                      " WHERE id = ?", [Config::DEFAULT_USER_ID], PDO::FETCH_COLUMN);

    $client = new WebPageTestClient($apiKey[0]);

    for ($j = 0; $j < count($userUrls); $j++)
    {
        $urlsId = $database->executeQuery("SELECT id FROM " . DatabaseTable::USER_URL, [], PDO::FETCH_COLUMN);

        for ($k = 0; $k < count($userLocations); $k++)
        {
            $wptTestId = $client->runNewTest($userUrls[$j], $userLocations[$k]['location']);

            $locationsId = $database->executeQuery("SELECT id FROM " . DatabaseTable::WPT_LOCATION, [], PDO::FETCH_COLUMN);

            $data = [];
            $data[] = $usersId[$i];
            $data[] = $urlsId[$j];
            $data[] = $locationsId[$k];
            $data[] = $wptTestId;
            $data[] = 0;

            $database->executeQuery("INSERT INTO " . DatabaseTable::TEST_INFO . " (user_id, url_id, location_id, test_id, is_completed)
                                     VALUES (?, ?, ?, ?, ?)", [$usersId[$i], $urlsId[$j], $locationsId[$k],  $wptTestId, 0]);
            print_r($data);
        }
    }
}