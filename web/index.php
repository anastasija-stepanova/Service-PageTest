<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->checkArraySession('index.php');

$databaseDataManager = new DatabaseDataManager();

$userId = $sessionManager->getUserId();
$domainsData = $databaseDataManager->getUserDomainsData($userId);

$userSettings = [];
foreach ($domainsData as $domainData)
{
    if (array_key_exists('id', $domainData))
    {
        $userLocations = $databaseDataManager->getUserLocations($userId, $domainData['id']);

        if (array_key_exists('domain_name', $domainData))
        {
            $userSettings[$domainData['domain_name']]['domain_id'] = $domainData['id'];
            $userSettings[$domainData['domain_name']]['locations'] = $userLocations;
        }
    }
}

$twigWrapper = new TwigWrapper(PathProvider::getPathTemplates());

$layout = $twigWrapper->getLoadedLayout('layout.tpl');

$paramsArray = [
    'layout' => $layout,
    'userSettings' => $userSettings
];

$twigWrapper->displayTemplate('index.tpl', $paramsArray);