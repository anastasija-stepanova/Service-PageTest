<?php
require_once  '../vendor/autoload.php';

function autoloader($fileName)
{
    $extension = '.php';
    require_once __DIR__ . '/' . $fileName . $extension;
}

spl_autoload_register('autoloader');