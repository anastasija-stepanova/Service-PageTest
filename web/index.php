<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$templateLoader = new Twig_Loader_Filesystem('../src/templates/');
$twig = new Twig_Environment($templateLoader);
$template = $twig->load('layout.tpl');

echo $template->render(array(
    'content' => $twig->load('main_page.tpl'),
));