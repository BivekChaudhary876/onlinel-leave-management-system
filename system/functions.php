<?php 
function get_current_controller(){

    $action = !empty( $_GET[ 'action' ] ) ? $_GET[ 'action' ] : 'user';
    $action = explode( '/', $action );
    return $action[ 0 ];
}

function get_current_method(){
    // "index" is our default method
    if( empty( $_GET[ 'action' ] ) ){
        return 'index';
    }
    $action = explode( '/', $_GET[ 'action' ] );
    // dd( $action );

    return !empty( $action[ 1 ] ) ? $action[ 1 ] : 'index';
}

function redirect( $controller, $method = '' ){

    $path = $controller;
    if( !empty( $method ) ){
        $path .= '/' . $method;
    }
    header("Location: /leave-management-system/{$path}");
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

  function pagination( $args ){

    if( $args[ 'total' ] == 0 ){
        return;
    }
    $page = isset( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : 1;
    $total_page = ceil( $args[ 'total' ] / 2 );
    $current_query = $_GET;
    unset( $current_query[ 'page' ] ); 
    unset( $current_query[ 'action' ] ); 
    $query_string = http_build_query( $current_query );

    if( !empty( $query_string ) ) {
        $query_string = '&' . $query_string;
    }
    ?>
    <div class="text-center">
        <ul class="pagination">
            <li class="page-item <?= ( $page <= 1 ) ? 'disabled' : '' ?>">
            <a class="page-link" href="<?php echo $args[ 'controller' ]; ?>?page=<?= $page - 1 ?><?= $query_string ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
            </li>
        <?php for ($i = 1; $i <= $total_page; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo $args[ 'controller' ]; ?>?page=<?= $i ?><?= $query_string ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
            <li class="page-item <?= ( $page >= $total_page ) ? 'disabled' : '' ?>">
            <a class="page-link" href="<?php echo $args[ 'controller' ]; ?>?page=<?= $page + 1 ?><?= $query_string ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li>
        </ul>
    </div>
    <?php
  }