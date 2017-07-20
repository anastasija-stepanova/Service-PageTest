<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
$users = $database->executeQuery("SELECT id FROM " . DatabaseTable::USER);
$urls = $database->executeQuery("SELECT url FROM " . DatabaseTable::USER_URL);
$userLocations = $database->executeQuery("SELECT wpt_location_id FROM " . DatabaseTable::USER_LOCATION);

$listUsers = '';
for ($i = 0; $i < count($users); $i++)
{
    $user = $users[$i]['id'];
    $listUsers .= "<div>$user</div>";
}

$listUserUrls = '';
for ($i = 0; $i < count($urls); $i++)
{
    $url = $urls[$i]['url'];
    $listUserUrls .= "<div>$url</div>";
}

$listUserLocations = '';
for ($i = 0; $i < count($userLocations); $i++)
{
    $location = $userLocations[$i]['wpt_location_id'];
    $ids = $database->executeQuery("SELECT id FROM " . DatabaseTable::WPT_LOCATION);
    $idLocations = $ids[$i]['id'];
    $listUserLocations .= "<div class='checkbox'><label><input type='checkbox' name='location' value='$idLocations'>$location</label></div>";
}

$vars = [
    '$listUsers' => $listUsers,
    '$listUserUrls' => $listUserUrls,
    '$listUserLocations' => $listUserLocations
];

$templateLoader = new TemplateLoader();
$templateLoader->loadTemplate('layout_two.tpl', $vars);