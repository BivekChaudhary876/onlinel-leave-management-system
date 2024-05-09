<?php
$controller_folder = PATH . '/application/controllers/';

$controller_files = glob($controller_folder . '*.php');

$controller_names = [];
foreach ($controller_files as $file) {
    $base_name = basename($file); 
    $controller_name = str_replace(['_controller.php', '_'], ['', ' '], $base_name);
    $controller_names[] = strtolower(trim($controller_name));
}

$current_controller = get_current_controller();

?>
<div class="sidebar">
    <ul class="nav nav-pills flex-column">
        <?php
        foreach ($controller_names as $controller) {
            $is_admin = in_array( $controller, ['type', 'user']);

            if( $is_admin && !is_admin() ){
                continue;
            }
            $is_active = ($current_controller === $controller) ? 'active' : '';
            $controller_url = ($controller === 'user') ? $controller . '/list' : $controller;
            ?>
            <li class="nav-item">
                <a class="nav-link link-body-emphasis nav-list <?php echo $is_active; ?>" href="<?php echo strtolower( str_replace( ' ', '', $controller_url ) ); ?>">
                    <?php echo icon( $controller ); ?>
                    <?php echo ucwords( $controller ); ?>
                </a>
            </li>
            <?php
        }
        ?>
        <li class="nav-item">
            <?php if ( isset( $_SESSION['current_user'])): ?>
                <a class="nav-link nav-list logout" href="dashboard/logout"><?php echo icon("logout"); ?>Logout</a>
            <?php endif ;?>
        </li>
    </ul>
</div>
