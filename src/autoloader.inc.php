<?php
require_once  __DIR__ . '../vendor/autoload.php';
require_once  __DIR__ . 'Autoloader.php';

$autoloader = new Autoloader();

spl_autoload_register([$autoloader, 'autoload']);