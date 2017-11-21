<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionWrapper();
$sessionClient->restoreSession();

if (empty($_POST))
{
    $webServerRequest = new WebServerRequest();
    $pathProvider = new PathProvider();
    $twigWrapper = new TwigWrapper($pathProvider->getPathTemplates());

    $isExistsUrl = $webServerRequest->getKeyIsExists('url');

    if (!$isExistsUrl)
    {
        echo $twigWrapper->renderTemplate('auth.tpl');
        return;
    }

    $paramsArray = [
        'url' => $webServerRequest->getGetKeyValue('url')
    ];
    echo $twigWrapper->renderTemplate('auth.tpl', $paramsArray);
}
else
{
    $userAuth = new UserAuth($sessionClient);
    echo $userAuth->userAuthorization();
}