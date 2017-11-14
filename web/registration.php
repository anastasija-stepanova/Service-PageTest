<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionClient = new SessionClient();
$sessionClient->restoreSession();

if (empty($_POST))
{
    $templateLoader = new Twig_Loader_Filesystem('../src/templates/');
    $twig = new Twig_Environment($templateLoader);
    echo $twig->render('registration.tpl');
    return;
}

$registrationClient = new RegistrationClient($sessionClient);
if ($registrationClient->checkUserLogin() && $registrationClient->checkUserPassword() && $registrationClient->checkApiKey())
{
    $passwordHash = $sessionClient->passwordToHash($registrationClient->userPassword);
    $registrationClient->databaseDataManager->saveNewUser($registrationClient->userLogin, $passwordHash, $registrationClient->apiKey);
    echo RequireStatus::SUCCESS_STATUS;
}