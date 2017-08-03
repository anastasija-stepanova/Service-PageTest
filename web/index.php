<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);
$layout = $twig->load('layout.tpl');

$twig->display('main_page.tpl', array(
    'layout' => $layout
));