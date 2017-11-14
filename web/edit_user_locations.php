<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsLocations = $webServerRequest->postKeyExists('locations');

if ($isExistsLocations != null)
{
    $json = $webServerRequest->getPostKeyValue('locations');
    $userLocationsEditor = new UserLocationsEditor($sessionClient);
    $userLocationsEditor->editUserLocations($json);
}