<?php
session_start();

if(empty($_SESSION['admin'])) {
    $_SESSION['admin'] = false;
}

$rootAppDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '..';

$array = explode('/', $_SERVER['SCRIPT_NAME']);
array_pop($array);
$webUrl = implode('/', $array);

define('APP_WEB_URL', $_SERVER['HTTP_HOST'] . $webUrl);
define('APP_WEB_PAGE', $webUrl);


include $rootAppDir . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
include $rootAppDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'config.php';
include $rootAppDir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'eloquent.php';


$parts = parse_url($_SERVER['REQUEST_URI']);

switch ($parts['path']) {
    case $webUrl . '/':
        $controller = new App\Controller\Tasks();
        $controller->indexAction();
        break;

    case $webUrl . '/save':
        $controller = new App\Controller\Tasks();
        $controller->saveAction();
        break;

    case $webUrl . '/redact':
        $controller = new App\Controller\Tasks();
        $controller->redactAction();
        break;

    case $webUrl . '/login':
        $controller = new App\Controller\Tasks();
        $controller->loginAction();
        break;

    case $webUrl . '/out':
        $controller = new App\Controller\Tasks();
        $controller->outAction();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        break;
}


