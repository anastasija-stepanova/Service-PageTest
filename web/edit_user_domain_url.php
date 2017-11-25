<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$preservedUrl = WebServerRequest::getGetKeyValue('preservedUrl');
$removableUrls = WebServerRequest::getPostKeyValue('deletableUrls');

if ($preservedUrl != null)
{
    $userDomainUrlEditor = new UserDomainUrlEditor($sessionManager);
    $userDomainUrlEditor->saveNewUrl($preservedUrl);
}
else if ($removableUrls != null)
{
    $userDomainUrlEditor = new UserDomainUrlEditor($sessionManager);
    $userDomainUrlEditor->deleteUrl($removableUrls);
}