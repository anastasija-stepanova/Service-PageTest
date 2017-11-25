<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$newDomainJson = WebServerRequest::getPostKeyValue('domain');
$editableDomainJson = WebServerRequest::getPostKeyValue('editableDomain');

if ($newDomainJson !=  null)
{
    $userDomainEditor = new UserDomainEditor($sessionManager);
    $userDomainEditor->saveNewDomain($newDomainJson);
}
elseif ($editableDomainJson != null)
{
    $userDomainEditor = new UserDomainEditor($sessionManager);
    $userDomainEditor->editExistingDomain($editableDomainJson);
}