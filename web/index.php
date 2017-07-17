<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
$locations = $database->executeQuery("SELECT location FROM " . DatabaseTable::WPT_LOCATION);

$listLocations = '';
for ($i = 0; $i < count($locations); $i++)
{
    $location = $locations[$i]['location'];
    $listLocations .= "<div class='checkbox'><label><input type='checkbox' value=''>$location</label></div>";
}

$urls = $database->executeQuery("SELECT url FROM " . DatabaseTable::USER_URL);

$listUrls = '';
for ($i = 0; $i < count($urls); $i++)
{
    $url = $urls[$i]['url'];
    $listUrls .= "<li>$url</li>";
}

$vars = [
    '[[$listLocations]]' => $listLocations,
    '[[$listUrls]]' => $listUrls
];

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('layout.tpl', $vars);