<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!isset($_SESSION['userId']))
{
    header('Location: auth.php');
    exit();
}

if (array_key_exists('locations', $_POST))
{
    $databaseDataProvider = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $locations = $_POST['locations'];
    $jsonDecode = json_decode($locations, true);

    if (array_key_exists('value', $jsonDecode))
    {
        $existingLocations = $databaseDataProvider->getExistingLocations($_SESSION['userId']);
        foreach ($existingLocations as $existingLocation)
        {
            $oldLocations = [];
            foreach ($oldLocations as $oldLocation)
            {
                $oldLocations[] = $oldLocation;
            }

            $newLocations = [];
            foreach ($jsonDecode['value'] as $newLocation)
            {
                $newLocations[] = $newLocation;
            }

            $removableItems = array_diff($oldLocations, $newLocations);
            foreach ($removableItems as $value)
            {
                $databaseDataProvider->deleteUserDomainLocation($existingLocation['domain_id'], $value);
            }

            $inlaysItems = array_diff($newLocations, $oldLocations);
            foreach ($inlaysItems as $value)
            {
                $databaseDataProvider->saveUserDomainLocation($existingLocation['domain_id'], $value);
            }
        }
    }
}