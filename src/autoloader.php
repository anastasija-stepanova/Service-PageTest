<?php
require_once  '../vendor/autoload.php';

function autoload($fileName)
{
    $expansion = '.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/Service-PageTest/src/' . $fileName . $expansion;
}

spl_autoload_register('autoload');