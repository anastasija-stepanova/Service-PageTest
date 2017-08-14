<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

ini_set('session.gc_maxlifetime', 1800);
ini_set('session.cookie_lifetime', 1800);

session_start();

if (array_key_exists('userId', $_SESSION))
{
    if (array_key_exists('url', $_GET))
    {
        $url = $_GET['url'];
        header("Location: $url");
    }
    else
    {
        header('Location: index.php');
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

        $databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
        $hash = md5($newUserPassword);
        $currentUserData = $databaseDataManager->getUserData($newUserLogin, $hash);

        if ($currentUserData && array_key_exists(0, $currentUserData))
        {
            $_SESSION['userId'] = $currentUserData[0]['id'];

            if (array_key_exists(0, $currentUserData))
            {
                $currentUserLogin = $currentUserData[0]['login'];
                $currentUserPassword = $currentUserData[0]['password'];

                if ($newUserLogin == $currentUserLogin && $hash == $currentUserPassword)
                {
                    if (array_key_exists('url', $_GET))
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

if (!array_key_exists('url', $_GET))
{
    echo $twig->render('home_page.tpl');
    exit();
}

echo $twig->render('home_page.tpl', array(
    'url' => $_GET['url']
));