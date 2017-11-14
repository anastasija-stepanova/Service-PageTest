<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->checkArraySession();

$webServerRequest = new WebServerRequest();
$isExistsPreservedUrl = $webServerRequest->postKeyExists('preservedUrl');
$isExistsDeletableUrls = $webServerRequest->postKeyExists('deletableUrls');

if ($isExistsPreservedUrl != null)
{
    $preservedUrl = $webServerRequest->getPostKeyValue('preservedUrl');
    $userDomainUrlEditor = new UserDomainUrlEditor($sessionClient);
    $userDomainUrlEditor->saveNewUrl($preservedUrl);
}
else if ($isExistsDeletableUrls)
{
    $removableUrls = $webServerRequest->getPostKeyValue('deletableUrls');
    $userDomainUrlEditor = new UserDomainUrlEditor($sessionClient);
    $userDomainUrlEditor->deleteUrl($removableUrls);
}