<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if (array_key_exists('locations', $_POST))
{
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $locations = $_POST['locations'];
    $jsonDecode = json_decode($locations, true);

    if (array_key_exists('value', $jsonDecode))
    {
        $existingLocations = $database->executeQuery("SELECT wpt_location_id FROM " . DatabaseTable::USER_LOCATION .
                                                     " WHERE user_id = ?", [Config::DEFAULT_USER_ID], PDO::FETCH_COLUMN);

        $oldLocations = [];
        for ($j = 0; $j < count($existingLocations); $j++)
        {
            $oldLocations[] = $existingLocations[$j];
        }

        $newLocations = [];
        for ($i = 0; $i < count($jsonDecode['value']); $i++)
        {
            $newLocations[] = $jsonDecode['value'][$i];
        }

        $removableItems = array_diff($oldLocations, $newLocations);
        foreach ($removableItems as $value)
        {
            $database->executeQuery("DELETE FROM " . DatabaseTable::USER_LOCATION .
                                    " WHERE user_id = ? and wpt_location_id = ?", [Config::DEFAULT_USER_ID, $value]);
        }

        $inlaysItems = array_diff($newLocations, $oldLocations);
        foreach ($inlaysItems as $value)
        {
            $database->executeQuery("INSERT INTO  " . DatabaseTable::USER_LOCATION .
                                    "(user_id, wpt_location_id) VALUES (?, ?)", [Config::DEFAULT_USER_ID, $value]);
        }
    }
}