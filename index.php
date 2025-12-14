<?php
// onlinecourse/index.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

/*
|--------------------------------------------------------------------------
| AUTOLOAD CONTROLLER + MODEL
|--------------------------------------------------------------------------
*/
spl_autoload_register(function ($class) {
    $controllerPath = __DIR__ . "/controllers/$class.php";
    $modelPath      = __DIR__ . "/models/$class.php";

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    } elseif (file_exists($modelPath)) {
        require_once $modelPath;
    }
});



$controllerName = $_GET['controller'] ?? 'course';
$action         = $_GET['action'] ?? 'index';

$controllerClass = ucfirst($controllerName) . 'Controller';

// Kiểm tra controller tồn tại
if (!class_exists($controllerClass)) {
    die("Controller <b>$controllerClass</b> không tồn tại");
}

// Khởi tạo controller
$controller = new $controllerClass();

// Kiểm tra action tồn tại
if (!method_exists($controller, $action)) {
    die("Action <b>$action</b> không tồn tại trong $controllerClass");
}

// Gọi action
$controller->$action();
