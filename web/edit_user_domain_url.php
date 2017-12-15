<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession();

$preservedUrlJson = WebServerRequest::getPostKeyValue('preservedUrl');
$removableUrlsJson = WebServerRequest::getPostKeyValue('deletableUrls');

$preservedUrlJsonDecoded = json_decode($preservedUrlJson, true);
$preservedUrlLastError = json_last_error();
$removableUrlsJsonDecoded = json_decode($removableUrlsJson, true);
$removableUrlsLastError = json_last_error();

if ($preservedUrlLastError === JSON_ERROR_NONE)
{
    $newUrl = $preservedUrlJsonDecoded['url'];
    if ($newUrl != null)
    {
        $domain = $preservedUrlJsonDecoded['domain'];
        $newUrl = $preservedUrlJsonDecoded['url'];
        $userDomainUrlEditor = new UserDomainUrlEditor($sessionManager);
        echo $userDomainUrlEditor->saveNewUrl($domain, $newUrl);
    }
}
else if ($removableUrlsLastError === JSON_ERROR_NONE)
{
    $urls = $removableUrlsJsonDecoded['urls'];
    if ($urls != null)
    {
        $domain = $removableUrlsJsonDecoded['domain'];
        $urls = $removableUrlsJsonDecoded['urls'];
        $userDomainUrlEditor = new UserDomainUrlEditor($sessionManager);
        echo $userDomainUrlEditor->deleteUrl($domain, $urls);
    }
}
else
{
    echo ResponseStatus::JSON_ERROR;
}