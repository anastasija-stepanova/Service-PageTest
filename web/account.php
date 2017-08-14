<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!array_key_exists('userId', $_SESSION))
{
    header('Location: auth.php?url=account.php');
    exit();
}

$databaseDataManager = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$locationsData = $databaseDataManager->getLocationData();

$listLocations = '';
foreach ($locationsData as $locationData)
{
    $location = $locationData['description'];
    $idLocation = $locationData['id'];
    $listLocations .= "<div class='checkbox'><label><input type='checkbox' name='location' value='$idLocation'>$location</label></div>";
}

$domainsData = $databaseDataManager->getUserDomainsData($_SESSION['userId']);
$listDomains = '';
$domain = '';
$listUrls = '';
foreach ($domainsData as $domainData)
{
     $domain = $domainData;
     $listDomains .= "<div>$domain</div>";

     $urlsData = $databaseDataManager->getUserUrlsData($_SESSION['userId']);

     $listUrls = '';
     foreach ($urlsData as $urlData)
     {
         if (array_key_exists('url', $urlData))
         {
             $url = $urlData['url'];
             $listUrls .= "<div>$url</div>";
         }
     }
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);

$layout = $twig->load('layout.tpl');

$twig->display('account.tpl', array(
    'layout' => $layout,
    'listLocations' => $listLocations,
    'domain' => $domain,
    'listUrls' => $listUrls
));