<?php 
session_start();
define( 'PATH', __DIR__ );

require_once PATH . '/config.php';

// load all the system files
$system_files = [
    'functions',
    'conn',
    'base_controller',
    'base_model'
];

foreach( $system_files as $system_file ){
    require_once PATH . '/system/' . $system_file . '.php';
}

// Handle current controller
$controller = get_current_controller();
$method = get_current_method();

$controller_path = PATH . '/application/controllers/' . $controller . '_controller.php';

if( file_exists( $controller_path ) ){
    require_once $controller_path;
    $class = ucfirst( $controller . '_Controller' );
    $obj = new $class();
    call_user_func_array( array( $obj, $method ), array( 'dynamic invoke' ) );
    
}else{
    die( 'controller not found' );
}

Conn::get_instance()->close();