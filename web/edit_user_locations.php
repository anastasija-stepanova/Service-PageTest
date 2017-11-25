<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$webServerRequest = new WebServerRequest();
$locations = WebServerRequest::getPostKeyValue('locations');

if ($locations != null)
{
    $userLocationsEditor = new UserLocationsEditor($sessionManager);
    $userLocationsEditor->editUserLocations($locations);
}