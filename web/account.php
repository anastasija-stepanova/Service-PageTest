<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession('account.php');

$databaseDataManager = new DatabaseDataManager();
$locationsData = $databaseDataManager->getLocationData();
$userId = $sessionManager->getUserId();
$domainsData = $databaseDataManager->getUserDomainsData($userId);

$userSettings = [];
foreach ($domainsData as $domainData)
{
    if (array_key_exists('id', $domainData))
    {
        $urlsData = $databaseDataManager->getUserUrlsData($userId, $domainData['id']);
        $userLocations = $databaseDataManager->getUserLocations($userId, $domainData['id']);

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

$twigWrapper = new TwigWrapper(PathProvider::getPathTemplates());

$layout = $twigWrapper->getLoadedLayout('layout.tpl');
$paramsArray = [
    'layout' => $layout,
    'userSettings' => $userSettings,
    'locationsData' => $locationsData
];

$twigWrapper->displayTemplate('account.tpl', $paramsArray);