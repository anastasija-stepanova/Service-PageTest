<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

const SUCCESSFUL_STATUS = 200;

$database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);

$users = $database->executeQuery("SELECT * FROM " . DatabaseTable::USER);
$listUsers = '';
for ($i = 0; $i < count($users); $i++)
{
    $userId = $users[$i]['id'];
    $user = $users[$i]['login'];
    $listUsers .= "<div>$user</div>";
}

$urls = $database->executeQuery("SELECT url FROM " . DatabaseTable::USER_URL . " WHERE user_id = ?", [Config::DEFAULT_USER_ID]);
$listUserUrls = '';
$urlsArray = [];
for ($i = 0; $i < count($urls); $i++)
{
    $url = $urls[$i]['url'];
    $urlsArray[] = $url;
    $listUserUrls .= "<div>$url</div>";
}

$userLocations = $database->executeQuery("SELECT * FROM user_location LEFT JOIN wpt_location USING(id)");
$listUserLocations = '';
$locationsArray = [];
for ($i = 0; $i < count($userLocations); $i++)
{
    $location = $userLocations[$i]['location'];
    $locationsArray[] = $location;
    $listUserLocations .= "<div>$location</div>";
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);
$template = $twig->loadTemplate('layout.tpl');

echo $template->render(array(
    'listUsers' => $listUsers,
    'listUserUrls' => $listUserUrls,
    'listUserLocations' => $listUserLocations
));

$client = new WebPageTestClient();

$testIdsArray = [];
for ($i = 0; $i < count($urlsArray); $i++)
{
    for ($j = 0; $j < count($locationsArray); $j++)
    {
        $wptTestId = $client->runNewTest($urlsArray[$i], $locationsArray[$j]);
        $database->executeQuery("INSERT INTO " . DatabaseTable::TEST_INFO . " (user_id, test_id) VALUES (?, ?)", [Config::DEFAULT_USER_ID, $wptTestId]);

        $dataArray = $database->selectOneRowDatabase("SELECT id FROM " . DatabaseTable::TEST_INFO . " WHERE test_id = ?", [$wptTestId]);

        if (array_key_exists('id', $dataArray))
        {
            $testId = $dataArray['id'];
            $testIdsArray[] = $testId;
        }
    }
}

for ($i = 0; $i < count($testIdsArray); $i++)
{
    $dataArray = $database->selectOneRowDatabase("SELECT test_id FROM " . DatabaseTable::TEST_INFO . " WHERE id = ?", [$testIdsArray[$i]]);

    if (array_key_exists('test_id', $dataArray))
    {
        $wptTestId = $dataArray['test_id'];
        $testStatus = $client->checkTestState($wptTestId);

        if ($testStatus != null && array_key_exists('statusCode', $testStatus) && $testStatus['statusCode'] == SUCCESSFUL_STATUS)
        {
            $result = $client->getResult($wptTestId);
            $wptResponseHandler = new WebPageTestResponseHandler();
            $wptResponseHandler->handle($result);
        }
    }
}