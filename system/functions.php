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

function get_active_widgets(){
    $setting_m = load_model( 'setting' );
    $db_widgets = $setting_m->get( [ "name"=>"widget_order" ] );
    if( empty( $db_widgets[0]["value"] ) ){
        return [];
    }
    $db_widgets = unserialize( $db_widgets[0][ "value" ] );
    return $db_widgets;
}

function load_widgets(){
    ?>
    <div class="row">
        <?php
            $active_widgets = get_active_widgets();
            $widgets_area = [
                'first'  => [],
                'second' => [],
                'third'  => []
            ];

            foreach( $active_widgets as $col => $widgets ){
                foreach( $widgets as $widget ){
                    $class = str_replace( '-', '_', $widget ) . '_widget';
                    require_once PATH . '/application/widgets/' . $class . '.php';
                    $obj = new $class();
                    $widgets_area[ $col ][] = $obj;
                }
            }

            foreach( $widgets_area as $i => $widgets ){
                ?>
                <div id="widget-area-<?php echo $i; ?>" class="widget-area col-4">
                    <div class="droppable-widget-area">
                        <?php 
                            foreach( $widgets as $widget ){
                                echo $widget->render();
                            }
                        ?>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
    <?php
}

function dd( $v ){
    ?>
    <div class="var-dump">
        <pre>
            <?php print_r( $v, true ); ?>
        </pre>
    </div>
    <?php
    die;
}

function print_pre( $args ){
    echo "<pre>",
    print_r( $args, true ),
    "</pre>";
}

function get_paginated_sql( $sql ){
    $per_page = get_per_page();
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

function indexing(){
    // Calculate the starting index based on the current page and items per page
    $start_index = ( get_current_page() - 1 ) * get_per_page();
    return $start_index;
}

function is_admin(){
    return $_SESSION[ 'current_user' ][ 'role' ] == 'admin';
}

function is_user(){
    return $_SESSION[ 'current_user' ][ 'role' ] == 'user';
}

function current_user(){
    return $_SESSION['current_user']['username'];
}

function db(){
    return Conn::get_instance();
}

function get_current_user_id(){
    return $_SESSION[ 'current_user' ][ 'id' ];
}

function get_current_page(){
    return isset( $_GET[ 'page' ] ) ? intval( $_GET[ 'page' ]) : 1;
}

function get_option( $key ){
    $setting = load_model( 'setting' );
    $pp = $setting->get( [ 'name' => $key ], false );
    return $pp[ 0 ][ 'value' ];
}

function get_per_page(){
    return get_option( 'per_page' );
}

function pagination( $args ){

    if( $args[ 'total' ] == 0 ){
        return;
    }

    $page = get_current_page();
    $total_page = ceil( $args[ 'total' ] / get_per_page() );
    $current_query = $_GET;
    unset( $current_query[ 'page' ] ); 
    unset( $current_query[ 'action' ] ); 
    $query_string = http_build_query( $current_query );

    if( !empty( $query_string ) ) {
        $query_string = '&' . $query_string;
    }
    ?>
    <div class="pagination-container">
        <ul class="pagination-list">
            <li class="pagination-item <?= ( $page <= 1 ) ? 'disabled' : '' ?>">
            <a class="pagination-link" href="<?php echo $args[ 'controller' ]; ?>?page=<?= $page - 1 ?><?= $query_string ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
            </li>
        <?php for ($i = 1; $i <= $total_page; $i++): ?>
            <li class="pagination-item  <?php echo ($i == $page) ? 'active' : '' ;?>">
            <a class="pagination-link" href="<?php echo $args[ 'controller' ]; ?>?page=<?= $i ?><?= $query_string ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
            <li class="pagination-item <?= ( $page >= $total_page ) ? 'disabled' : '' ?>">
            <a class="pagination-link" href="<?php echo $args[ 'controller' ]; ?>?page=<?= $page + 1 ?><?= $query_string ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li>
        </ul>
    </div>
<?php
}

function icon( $c ){
    $class = [ "edit" => "fa-pencil-square-o", "view" => "fa-eye", "delete" => "fa-trash" ,"dashboard" => "fa-tachometer", "holiday" => "fa-superpowers", "leave" => "fa-leaf", "user" => "fa-users", "setting" => "fa-cog", "type" => "fa-puzzle-piece", "widget" => "fa-sitemap", "login" => "fa-sign-in", "logout" => "fa-sign-out", "birthday"=>"fa-birthday-cake", "chevron-right" => "fa-chevron-right",];
    ?>
    <i class="fa <?php echo isset( $class[ $c ] ) ? esc_attr( $class[ $c ] ) : esc_attr( $c ); ?>"></i>
    <?php
}


function esc_attr( $string ){
    return htmlspecialchars( $string, ENT_QUOTES, 'UTF-8' );
}