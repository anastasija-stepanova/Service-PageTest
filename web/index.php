<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();

$sessionClient->checkArraySession('index.php');

$databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$domainsData = $databaseDataManager->getUserDomainsData($_SESSION['userId']);

$userSettings = [];
foreach ($domainsData as $domainData)
{
    if (array_key_exists('id', $domainData))
    {
        $userLocations = $databaseDataManager->getUserLocations($_SESSION['userId'], $domainData['id']);

        if (array_key_exists('domain_name', $domainData))
        {
            $userSettings[$domainData['domain_name']]['domain_id'] = $domainData['id'];
            $userSettings[$domainData['domain_name']]['locations'] = $userLocations;
        }
    }
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);
$layout = $twig->load('layout.tpl');

$twig->display('main_page.tpl', array(
    'layout' => $layout,
    'userSettings' => $userSettings
));