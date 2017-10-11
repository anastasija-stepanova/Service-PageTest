<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();

$sessionClient->checkArraySession('account.php');

$databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
$locationsData = $databaseDataManager->getLocationData();
$domainsData = $databaseDataManager->getUserDomainsData($_SESSION['userId']);

$userSettings = [];
foreach ($domainsData as $domainData)
{
    if (array_key_exists('id', $domainData))
    {
        $urlsData = $databaseDataManager->getUserUrlsData($_SESSION['userId'], $domainData['id']);
        $userLocations = $databaseDataManager->getUserLocations($_SESSION['userId'], $domainData['id']);

        if (array_key_exists('domain_name', $domainData))
        {
            $userSettings[$domainData['domain_name']]['locations'] = $userLocations;
            foreach ($urlsData as $url)
            {
                if (array_key_exists('url', $url))
                {
                    $userSettings[$domainData['domain_name']]['urls'][] = $url['url'];
                }
            }
        }
    }
}


$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);
$layout = $twig->load('layout.tpl');

$twig->display('account.tpl', array(
    'layout' => $layout,
    'userSettings' => $userSettings,
    'locationsData' => $locationsData
));

