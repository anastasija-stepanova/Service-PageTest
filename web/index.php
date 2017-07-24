<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
$locations = $database->executeQuery("SELECT location FROM " . DatabaseTable::WPT_LOCATION);

$listLocations = '';
for ($i = 0; $i < count($locations); $i++)
{
    $location = $locations[$i]['location'];
    $ids = $database->executeQuery("SELECT id FROM " . DatabaseTable::WPT_LOCATION);
    $idLocations = $ids[$i]['id'];
    $listLocations .= "<div class='checkbox'><label><input type='checkbox' name='location' value='$idLocations'>$location</label></div>";
}

$urls = $database->executeQuery("SELECT url FROM " . DatabaseTable::USER_URL);

$listUrls = '';
for ($i = 0; $i < count($urls); $i++)
{
    $url = $urls[$i]['url'];
    $listUrls .= "<div>$url</div>";
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');

$twig = new Twig_Environment($templateLoader);

$template = $twig->loadTemplate('layout.tpl');

echo $template->render(array(
    'listLocations' => $listLocations,
    'listUrls' => $listUrls
));