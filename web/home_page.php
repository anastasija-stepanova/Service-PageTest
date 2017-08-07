<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);
echo $twig->render('home_page.tpl');

if (array_key_exists('dataForm', $_POST))
{
    $database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

    $newUserData = $_POST['dataForm'];
    $jsonDecode = json_decode($newUserData, true);

    if (array_key_exists('login', $jsonDecode))
    {
        $newUserLogin = $jsonDecode['login'];

        if (array_key_exists('password', $jsonDecode))
        {
            $newUserPassword = $jsonDecode['password'];

            $currentUserData = $database->executeQuery("SELECT login, password FROM " . DatabaseTable::USER);

            if (array_key_exists(0, $currentUserData))
            {
                $currentUserLogin = $currentUserData[0]['login'];
                $currentUserPassword = $currentUserData[0]['password'];
                $_SESSION['authorization'] = true;

                if ($newUserLogin == $currentUserLogin && $newUserPassword == $currentUserPassword)
                {
                    if ($_SESSION['authorization'])
                    {
                        header('Location: http://localhost/Service-PageTest/web/index.php');
                    }
                    else
                    {
                        header('Location: http://localhost/Service-PageTest/web/home_page.php');
                    }
                }
            }
        }
    }
}