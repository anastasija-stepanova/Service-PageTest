<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->restoreSession();

if (empty($_POST))
{
    $webServerRequest = new WebServerRequest();
    $templateLoader = new Twig_Loader_Filesystem('../src/templates/');
    $twig = new Twig_Environment($templateLoader);

    $isExistsUrl = $webServerRequest->getKeyIsExists('url');

    if (!$isExistsUrl)
    {
        echo $twig->render('auth.tpl');
        return;
    }

    echo $twig->render('auth.tpl', array(
        'url' => $webServerRequest->getGetKeyValue('url')
    ));
    return;
}

$authClient = new AuthClient($sessionClient);
$authClient->initializeUserData();