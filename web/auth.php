<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();

$sessionClient->restoreSession();

if (array_key_exists('userLogin', $_POST))
{
    $newUserLogin = $_POST['userLogin'];

    if (array_key_exists('userPassword', $_POST))
    {
        $newUserPassword = $_POST['userPassword'];

        $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

        $passwordHash = $sessionClient->passwordToHash($newUserPassword);
        $currentUserData = $databaseDataManager->getUserData($newUserLogin, $passwordHash);

        loginUser($sessionClient, $currentUserData, $newUserLogin, $passwordHash);
    }
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);

if (!array_key_exists('url', $_GET))
{
    echo $twig->render('auth.tpl');
    exit();
}

echo $twig->render('auth.tpl', array(
    'url' => $_GET['url']
));

function loginUser($sessionClient, $currentUserData, $newUserLogin, $passwordHash)
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