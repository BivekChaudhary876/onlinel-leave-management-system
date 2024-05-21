<?php
// index.php

session_start();
define('PATH', __DIR__);

require_once PATH . '/config.php';

// load all the system files
$system_files = [
    'functions',
    'conn',
    'base_controller',
    'base_model',
    'base_widget'
];

foreach ($system_files as $system_file) {
    require_once PATH . '/system/' . $system_file . '.php';
}

// Handle current controller
$controller = get_current_controller();
$method = get_current_method();

$controller_path = PATH . '/application/controllers/' . $controller . '_controller.php';

if( !file_exists( $controller_path ) ){
    $controller_path = PATH . '/application/controllers/error_controller.php';
    $controller = 'Error';
    $method = 'index';
}

require_once $controller_path;
$class = ucfirst($controller . '_Controller');
$obj = new $class();
// send remaining parts as parameter to the method         
$query = isset($_GET['action']) ? $_GET['action'] : '';
$parts = explode('/', $query);

if (method_exists($obj, $method)) {
    call_user_func_array(array($obj, $method), array_slice($parts, 2));
} else {
    // Redirect to error controller if method doesn't exist
    $controller_path = PATH . '/application/controllers/error_controller.php';
    require_once $controller_path;
    $error_obj = new Error_Controller();
    $error_obj->method_not_found();
}
Conn::get_instance()->close();
