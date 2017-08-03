<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
$locations = $database->executeQuery("SELECT description FROM " . DatabaseTable::WPT_LOCATION, [], PDO::FETCH_COLUMN);

$listLocations = '';
for ($i = 0; $i < count($locations); $i++)
{
    $location = $locations[$i];
    $ids = $database->executeQuery("SELECT id FROM " . DatabaseTable::WPT_LOCATION, [], PDO::FETCH_COLUMN);
    $idLocations = $ids[$i];
    $listLocations .= "<div class='checkbox'><label><input type='checkbox' name='location' value='$idLocations'>$location</label></div>";
}

$urls = $database->executeQuery("SELECT url FROM " . DatabaseTable::USER_URL, [], PDO::FETCH_COLUMN);

$listUrls = '';
for ($i = 0; $i < count($urls); $i++)
{
    $url = $urls[$i];
    $listUrls .= "<div>$url</div>";
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);

$layout = $twig->load('layout.tpl');

$twig->display('account.tpl', array(
    'layout' => $layout,
    'listLocations' => $listLocations,
    'listUrls' => $listUrls
));