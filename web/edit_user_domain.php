<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsDomain = $webServerRequest->postKeyExists('domain');
$isExistsEditableDomain = $webServerRequest->postKeyExists('editableDomain');

if ($isExistsDomain !=  null)
{
    $json = $webServerRequest->getPostKeyValue('domain');
    $userDomainEditor = new UserDomainEditor($sessionClient);
    $userDomainEditor->saveNewDomain($json);
}
elseif ($isExistsEditableDomain)
{
    $json = $webServerRequest->getPostKeyValue('editableDomain');
    $userDomainEditor = new UserDomainEditor($sessionClient);
    $userDomainEditor->editExistingDomain($json);
}