<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$newDomainJson = WebServerRequest::getPostKeyValue('domain');
$editableDomainJson = WebServerRequest::getPostKeyValue('editableDomain');

$newDomainJsonDecoded = json_decode($newDomainJson, true);
$newDomainLastError = json_last_error();
$editableDomainJsonDecoded = json_decode($editableDomainJson, true);
$editableDomainLastError = json_last_error();

if ($newDomainLastError === JSON_ERROR_NONE)
{
    $newDomain = $newDomainJsonDecoded['value'];
    if ($newDomain != null)
    {
        $userDomainEditor = new UserDomainEditor($sessionManager);
        echo $userDomainEditor->saveNewDomain($newDomain);
    }
}
else if ($editableDomainLastError === JSON_ERROR_NONE)
{
    $currentDomain = $editableDomainJsonDecoded['currentDomain'];
    $newDomain = $editableDomainJsonDecoded['newDomain'];
    if ($currentDomain != null && $newDomain != null)
    {
        $userDomainEditor = new UserDomainEditor($sessionManager);
        echo $userDomainEditor->editExistingDomain($currentDomain, $newDomain);
    }
}
else
{
    echo ResponseStatus::JSON_ERROR;
}