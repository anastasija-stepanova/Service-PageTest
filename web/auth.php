<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->restoreSession();

$webServerRequest = new WebServerRequest();
$isExistsUserLogin =  $webServerRequest->postKeyIsExists('userLogin');

if ($isExistsUserLogin)
{
    $newUserLogin = $webServerRequest->getPostKeyValue('userLogin');
    $isExistsUserPassword =  $webServerRequest->postKeyIsExists('userPassword');

    if ($isExistsUserPassword)
    {
        $newUserPassword = $webServerRequest->getPostKeyValue('userPassword');

        $databaseDataManager = new DatabaseDataManager();

        $passwordHash = $sessionClient->passwordToHash($newUserPassword);
        $currentUserData = $databaseDataManager->getUserData($newUserLogin, $passwordHash);

        loginUser($sessionClient, $currentUserData, $newUserLogin, $passwordHash);
    }
}

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

function loginUser($sessionClient, array $currentUserData, string $newUserLogin, string $passwordHash): void
{
    if ($currentUserData && array_key_exists(0, $currentUserData))
    {
        $sessionClient->initializeArraySession($currentUserData[0]['id']);

        if (array_key_exists(0, $currentUserData))
        {
            $currentUserLogin = $currentUserData[0]['login'];
            $currentUserPassword = $currentUserData[0]['password'];

            if ($newUserLogin == $currentUserLogin && $passwordHash == $currentUserPassword)
            {
                $sessionClient->checkRedirect();
            }
        }
    }
}