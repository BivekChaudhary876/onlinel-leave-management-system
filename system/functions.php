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
            <?= print_r( $v, true ); ?>
        </pre>
    </div>
    <?php
    die;
}

function get_paginated_sql( $sql ){
    $per_page = 2;
    $page = isset( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : 1;
    $offset = ( $page - 1 ) * $per_page;

    return $sql . ' LIMIT ' .  $offset . ','.$per_page;
}

function get_status_badge( $status ){

    $all_status = [
        'pending' => [
            'class' => '-warning',
            'label' => 'Pending',
        ],
        'approved' => [
            'class' => '-success',
            'label' => 'Approved',
        ],
        'rejected' => [
            'class' => '-danger',
            'label' => 'Rejected',
        ]
    ];

    $label = $all_status[ $status ][ 'label' ];
    $c = $all_status[ $status ][ 'class' ];

    return "<span class='badge text-bg{$c}'>{$label}</span>";

  }

  function is_admin(){
    return $_SESSION[ 'current_user' ][ 'role' ] == 'admin';
  }
  
  function is_user(){
    return $_SESSION[ 'current_user' ][ 'role' ] == 'user';
  }

  function db(){
    return Conn::get_instance();
  }

  function get_current_user_id(){
    return $_SESSION[ 'current_user' ][ 'id' ];
  }