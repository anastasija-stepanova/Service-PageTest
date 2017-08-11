<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

ini_set('session.gc_maxlifetime', 1800);
ini_set('session.cookie_lifetime', 1800);

session_start();

if (isset($_SESSION['userId']))
{
    if (isset($_GET['url']))
    {
        $url = $_GET['url'];
        header("Location: $url");
    }
    else
    {
        header('Location: account.php');
    }
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);

if (array_key_exists('userLogin', $_POST))
{
    $newUserLogin = $_POST['userLogin'];

    if (array_key_exists('userPassword', $_POST))
    {
        $newUserPassword = $_POST['userPassword'];

        $databaseDataProvider = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

        $currentUserData = $databaseDataProvider->getUserData($newUserLogin, $newUserPassword);

        if ($currentUserData && array_key_exists(0, $currentUserData))
        {
            $_SESSION['userId'] = $currentUserData[0]['id'];

            if (array_key_exists(0, $currentUserData))
            {
                $currentUserLogin = $currentUserData[0]['login'];
                $currentUserPassword = $currentUserData[0]['password'];

                if ($newUserLogin == $currentUserLogin && $newUserPassword == $currentUserPassword)
                {
                    if (isset($_GET['url']))
                    {
                        $url = $_GET['url'];
                        header("Location: $url");
                    }
                    else
                    {
                        header('Location: index.php');
                    }
                }
            }
        }
    }
}

echo $twig->render('home_page.tpl');