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
    $start_index = (get_current_page() - 1) * get_per_page();
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
    return isset($_SESSION['page']) ? intval($_SESSION['page']) : 1;
}

function get_per_page(){
    return isset($_SESSION['per_page']) ? intval($_SESSION['per_page']) : 2;
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

function page_settings(){?>
    <div class="dropdown">
        <a href="dashboard/settings"><button class="btn" type="button">
            Settings
        </button></a>
    </div>
<?php
}

function total_status_count( $params ){?>
    <div class="row">
        <div class="my-3 text-center d-flex justify-content-evenly">
            <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br> <?php $params['total_leave']?></button>
            <button id="pendingBtn" class="btn btn-outline-warning">Pending<br> <?php $params['total_pending'] ?></button>
            <button id="approvedBtn" class="btn btn-outline-success">Approved<br> <?php $params['total_approved'] ?></button>
            <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br> <?php $params['total_rejected'] ?></button>
        </div>
    </div>
 <?php
}

function leave_list( $args ){?>
    <div class="modal fade" id="<?php echo $args['modal-id']?>">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <table class="table table-striped table-light table-hover">
                <thead>
                    <tr class="table-success text-center">
                        <th scope="col">S.No</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Department</th>
                        <th scope="col">Type</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php $l=1; ?>
                <?php foreach( $args['model'] as $leave_request ): ?>
                <?php if ( ( is_admin() && $leave_request['status'] == $args['current_status'] )|| ( is_user() && $leave_request['username'] == current_user() && $leave_request['status'] == $args['current_status'] ) )  : ?>
                    <tr class="text-center"> 
                        <td><?php  echo $l++ ?></td>
                        <td><?= $leave_request[ 'username' ];?></td>
                        <td><?= $leave_request[ 'email' ];?></td>
                        <td><?= $leave_request[ 'department' ];?></td>
                        <td><?php  echo $leave_request[ 'leave_type' ]; ?></td>
                        <td><?php  echo $leave_request[ 'from_date' ]; ?></td>
                        <td><?php  echo $leave_request[ 'to_date' ]; ?></td>
                        <td><?php  echo $leave_request[ 'description' ]; ?></td>
                        <td><?= get_status_badge( $leave_request[ 'status' ] ) ?></td>
                    </tr>
                <?php endif;?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}




