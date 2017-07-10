<?php
require_once  '../vendor/autoload.php';

function autoloader($fileName)
{
    $extension = '.php';
//    if (filetype($fileName) === 'dir')
//    {
//        autoloader($fileName . DIRECTORY_SEPARATOR);
//    }
//    elseif (filetype($fileName) === 'file')
//    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . $fileName . $extension;
//    }
}

spl_autoload_register('autoloader');