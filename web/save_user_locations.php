<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if (array_key_exists('locations', $_GET))
{
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $locations= $_GET['locations'];
    echo $locations;
//    $recordExists = $database->executeQuery("SELECT wpt_location_id FROM " . DatabaseTable::USER_LOCATION . " WHERE user_id = ?", [Config::DEFAULT_USER_ID]);
//    if (array_key_exists(0, $recordExists))
//    {
//        $database->executeQuery("UPDATE " . DatabaseTable::USER_LOCATION . " SET wpt_location_id = ?", [$locations]);
//    }
//    else
//    {
        $database->executeQuery("INSERT INTO " . DatabaseTable::USER_LOCATION . " (user_id, wpt_location_id) VALUES (?, ?)", [Config::DEFAULT_USER_ID, $locations[0]]);
    }
//}