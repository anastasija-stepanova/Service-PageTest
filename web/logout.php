<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionWrapper();
$sessionClient->logout();