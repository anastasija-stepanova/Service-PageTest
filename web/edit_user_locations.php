<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsLocations = $webServerRequest->postKeyIsExists('locations');

if ($isExistsLocations)
{
    $databaseDataManager = new DatabaseDataManager();

    $json = $webServerRequest->getPostKeyValue('locations');
    $jsonDecoded = json_decode($json, true);
    $lastError = json_last_error();

    if ($lastError === JSON_ERROR_NONE)
    {
        $domain = $jsonDecoded['domain'];
        $locations = $jsonDecoded['locationIds'];

        $domainId = $databaseDataManager->getUserDomain($domain);
        if (array_key_exists('id', $domainId))
        {
            $domainId = $domainId['id'];
        }

        $userId = $sessionClient->getUserId();
        $existingLocations = $databaseDataManager->getExistingLocations($userId, $domainId);

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
    else
    {
        return $lastError;
    }
}