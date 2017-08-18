<?php
require_once __DIR__ . '/../src/autoloader.inc.php';
session_start();
if (!array_key_exists('userId', $_SESSION))
{
    header('Location: auth.php');
    exit();
}
if (array_key_exists('data', $_POST))
{
    $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $json = $_POST['data'];
    $jsonDecode = json_decode($json, true);
    $domain = $jsonDecode['domain'];
    $locations = $jsonDecode['locations'];

    $domainId = $databaseDataManager->getUserDomain($domain);

    if (array_key_exists(0, $domainId))
    {
        $domainId = $domainId[0];
    }

    $existingLocations = $databaseDataManager->getExistingLocations($_SESSION['userId'], $domainId);

    if ($existingLocations)
    {
        $oldLocations = [];
        $existingDomainId = null;

        foreach ($existingLocations as $existingLocation)
        {
            $oldLocations[] = $existingLocation['wpt_location_id'];
            $existingDomainId = $existingLocation['user_domain_id'];
        }

        $newLocations = [];
        foreach ($locations as $newLocation)
        {
            $newLocations[] = $newLocation;
        }

        $removableItems = array_diff($oldLocations, $newLocations);
        foreach ($removableItems as $value)
        {
            $databaseDataManager->deleteUserDomainLocation($existingDomainId, $value);
        }

        $inlaysItems = array_diff($newLocations, $oldLocations);
        foreach ($inlaysItems as $value)
        {
            $databaseDataManager->saveUserDomainLocation($existingDomainId, $value);
        }
    }
    else
    {
        foreach ($locations as $location)
        {
            $databaseDataManager->saveUserDomainLocation($domainId, $location);
        }
    }
}