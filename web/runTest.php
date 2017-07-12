<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

if ($argv && array_key_exists(Config::FIRST_PARAM_ARGV, $argv))
{
    $siteUrl = $argv[Config::FIRST_PARAM_ARGV];
    $client = new WebPageTestClient();

    $testId = $client->runNewTest($siteUrl);

    echo $testId;
}
else
{
    echo 'Не передан параметр!';
}