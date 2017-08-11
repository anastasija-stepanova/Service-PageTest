<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

session_start();

if (!isset($_SESSION['userId']))
{
    header('Location: auth.php?url=index.php');
    exit();
}

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);
$layout = $twig->load('layout.tpl');

$twig->display('main_page.tpl', array(
    'layout' => $layout
));