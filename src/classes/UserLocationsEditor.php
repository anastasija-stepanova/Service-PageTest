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

    public function editUserLocations(string $domain, array $locations): int
    {
        $domainId = $this->databaseDataManager->getUserDomain($domain);
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
            return ResponseStatus::SUCCESS_STATUS;
        }
        else
        {
            $this->saveNewLocations($locations, $domainId);
            return ResponseStatus::SUCCESS_STATUS;
        }
    }

    private function saveNewLocations(array $locations, int $domainId): void
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
}