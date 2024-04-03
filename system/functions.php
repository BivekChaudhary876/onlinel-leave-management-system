<?php 
function get_current_controller(){
    // "user" is our default controller
    return isset( $_GET[ 'c' ] ) ? $_GET[ 'c' ] : 'user';
}

function get_current_method(){
    // "index" is our default model
    return isset( $_GET[ 'm' ] ) ? $_GET[ 'm' ] : 'index';
}

function redirect( $controller, $method = '' ){

    $method_param = '';
    if( !empty( $method ) ){
        $method_param = "&m={$method}";
    }

    header("Location: index.php?c={$controller}{$method_param}");
    exit;
}

function load_model( $model ){
    $model_path = PATH . '/application/models/' . $model . '_model.php';
    if( file_exists( $model_path ) ){
        require_once $model_path;
        $model_class = ucfirst( $model ) . '_Model';
        return new $model_class();
    }

    return false;
}

function dd( $v ){
    ?>
    <div class="var-dump">
        <pre>
            <?= print_r( $v ); ?>
        </pre>
    </div>
    <?php
    die;
}