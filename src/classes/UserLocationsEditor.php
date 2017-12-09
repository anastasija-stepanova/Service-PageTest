<?php

class UserLocationsEditor
{
    private $databaseDataManager;
    private $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
        $this->databaseDataManager = new DatabaseDataManager();
    }

    public function editUserLocations(string $json)
    {
        $jsonDecoded = json_decode($json, true);
        $lastError = json_last_error();

        if ($lastError === JSON_ERROR_NONE)
        {
            $domain = $jsonDecoded['domain'];
            $locations = $jsonDecoded['locationIds'];

            $domainId = $this->getDomainId($domain);
            $userId = $this->sessionManager->getUserId();
            $existingLocations = $this->databaseDataManager->getExistingLocations($userId, $domainId);

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
                $this->deleteLocations($removableItems, $existingDomainId);

                $inlaysItems = array_diff($newLocations, $oldLocations);
                $this->saveNewLocations($inlaysItems, $existingDomainId);
            }
            else
            {
                $this->saveNewLocations($locations, $domainId);
            }
        }
        return $lastError;
    }

    private function saveNewLocations($locations, $domainId): void
    {
        foreach ($locations as $locationId)
        {
            $this->databaseDataManager->saveUserDomainLocation($domainId, $locationId);
        }
    }

    private function deleteLocations(array $locations, int $domainId): void
    {
        foreach ($locations as $location)
        {
            $this->databaseDataManager->deleteUserDomainLocation($domainId, $location);
        }
    }

    private function getDomainId(string $domain)
    {
        $domainId = $this->databaseDataManager->getUserDomain($domain);
        if (array_key_exists('id', $domainId))
        {
            $domainId = $domainId['id'];
        }
        print_r($domainId);
        return $domainId;
    }
}