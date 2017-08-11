<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!isset($_SESSION['userId']))
{
    header('Location: auth.php?url=account.php');
    exit();
}

$databaseDataProvider = new DatabaseDataManager(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$locationsData = $databaseDataProvider->getLocationData();

$listLocations = '';
foreach ($locationsData as $locationData)
{
    $location = $locationData['description'];
    $idLocation = $locationData['id'];
    $listLocations .= "<div class='checkbox'><label><input type='checkbox' name='location' value='$idLocation'>$location</label></div>";
}

$domainsData = $databaseDataProvider->getUserDomainsData($_SESSION['userId']);
$listDomains = '';
$domain = '';
$listUrls = '';
foreach ($domainsData as $domainData)
{
     $domain = $domainData;
     $listDomains .= "<div>$domain</div>";

     $urlsData = $databaseDataProvider->getUserUrlsData($_SESSION['userId']);

     $listUrls = '';
     foreach ($urlsData as $urlData)
     {
         $listUrls .= "<div>$urlData</div>";
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