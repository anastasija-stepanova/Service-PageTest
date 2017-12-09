<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$preservedUrlJson = WebServerRequest::getPostKeyValue('preservedUrl');
$removableUrlsJson = WebServerRequest::getPostKeyValue('deletableUrls');

$preservedUrlDecoded = json_decode($preservedUrlJson, true);
$preservedUrlLastError = json_last_error();
$removableUrlsJsonDecoded = json_decode($removableUrlsJson, true);
$removableUrlsLastError = json_last_error();

if ($preservedUrlLastError === JSON_ERROR_NONE)
{
    $newUrl = $preservedUrlDecoded['url'];
    if ($newUrl != null)
    {
        $userDomainUrlEditor = new UserDomainUrlEditor($sessionManager);
        echo $userDomainUrlEditor->saveNewUrl($preservedUrlDecoded);
    }
}
else if ($removableUrlsLastError === JSON_ERROR_NONE)
{
    $urls = $removableUrlsJsonDecoded['urls'];
    if ($urls != null)
    {
        $userDomainUrlEditor = new UserDomainUrlEditor($sessionManager);
        $userDomainUrlEditor->deleteUrl($removableUrlsJsonDecoded);
    }
}
else
{
    echo $preservedUrlLastError;
    echo $removableUrlsLastError;
}