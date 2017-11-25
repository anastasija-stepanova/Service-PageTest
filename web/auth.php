<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->restoreSession();

if (empty($_POST))
{
    $webServerRequest = new WebServerRequest();
    $twigWrapper = new TwigWrapper(PathProvider::getPathTemplates());

    $urlParam = $webServerRequest->getGetKeyValue('url');
    if ($urlParam == null)
    {
        echo $twigWrapper->renderTemplate('auth.tpl');
        return;
    }

    $paramsArray = [
        'url' => $urlParam
    ];
    echo $twigWrapper->renderTemplate('auth.tpl', $paramsArray);
}
else
{
    $userAuth = new UserAuth($sessionManager);
    echo $userAuth->userAuthorization();
}