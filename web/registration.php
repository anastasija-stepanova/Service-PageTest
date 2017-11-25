<?php
require_once __DIR__ . '/../src/autoloader.inc.php';

$sessionManager = new SessionManager();
$sessionManager->restoreSession();

if (empty($_POST))
{
    $twigWrapper = new TwigWrapper(PathProvider::getPathTemplates());

    echo $twigWrapper->renderTemplate('registration.tpl');
    return;
}

$databaseDataManager = new DatabaseDataManager();
$userRegistration = new UserRegistration($sessionManager, $databaseDataManager);
$userLogin = getUserData('userLogin');
$userPassword = getUserData('userPassword');
$userPasswordChecked = getUserData('userPasswordChecked');
$apiKey = getUserData('apiKey');

if ($userLogin && $userPassword && $userPasswordChecked && $apiKey)
{
    $statusUserLogin = $userRegistration->getStatusLogin($userLogin);
    $statusUserPassword = $userRegistration->getStatusPassword($userPassword, $userPasswordChecked);
    $statusApiKey = $userRegistration->getStatusApiKey($apiKey);
    if ($statusUserLogin != ResponseStatus::SUCCESS_STATUS)
    {
        $statusCode = $statusUserLogin;
    }
    else if ($statusUserPassword != ResponseStatus::SUCCESS_STATUS)
    {
        $statusCode = $statusUserPassword;
    }
    else if ($statusApiKey != ResponseStatus::SUCCESS_STATUS)
    {
        $statusCode = $statusApiKey;
    }
    else if ($statusUserLogin == ResponseStatus::SUCCESS_STATUS && $statusUserPassword == ResponseStatus::SUCCESS_STATUS && $statusApiKey == ResponseStatus::SUCCESS_STATUS)
    {
        $passwordHash = PasswordHashCreator::passwordToHash($userPassword);
        $databaseDataManager->saveNewUser($userLogin, $passwordHash, $apiKey);
        $statusCode = ResponseStatus::SUCCESS_STATUS;
    }
    else
    {
        $statusCode = ResponseStatus::REGISTRATION_ERROR;
    }
    echo $statusCode;
}

function getUserData(string $arrayParam): string
{
    $userData = WebServerRequest::getPostKeyValue($arrayParam);
    return $userData != null ? $userData : null;
}