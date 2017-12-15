<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$webServerRequest = new WebServerRequest();
$locationsJson = WebServerRequest::getPostKeyValue('locations');

$jsonDecoded = json_decode($locationsJson, true);
$lastError = json_last_error();

if ($lastError === JSON_ERROR_NONE)
{
    $domain = $jsonDecoded['domain'];
    $locations = $jsonDecoded['locationIds'];

    if ($locations != null)
    {
        $userLocationsEditor = new UserLocationsEditor($sessionManager);
        echo $userLocationsEditor->editUserLocations($domain, $locations);
    }
}
else
{
    echo ResponseStatus::JSON_ERROR;
}