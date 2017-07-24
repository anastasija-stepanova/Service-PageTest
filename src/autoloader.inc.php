<?php
require_once  __DIR__ . '/../vendor/autoload.php';
require_once  __DIR__ . '/classes/Autoloader.php';
require_once __DIR__ . '/../vendor/twig/twig/lib/Twig/Autoloader.php';


Twig_Autoloader::register();

$autoloader = new Autoloader();

spl_autoload_register([$autoloader, 'autoload']);