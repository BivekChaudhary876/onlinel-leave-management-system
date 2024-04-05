<?php 
abstract class Base_Controller{

    protected $model;

    protected $c; // store current controller

    protected $m; // store current method

    public function __construct(){

        $this->c = get_current_controller();
        $this->m = get_current_method();

        // check if allowd post methods are access throught other request methods
        if( isset( $this->post_methods ) && $_SERVER[ 'REQUEST_METHOD' ] != 'POST' && in_array( $this->m, $this->post_methods ) ){
            redirect( 'user' );
        }

        if( $this->is_logged_in() ){
            if( 'user' == $this->c && 'index' == $this->m ){
                redirect( 'dashboard' );
            }
        }else{
            // not logged int
            if( !( 'user' == $this->c && ( 'index' == $this->m || 'login' == $this->m ) ) ){
                redirect( 'user' );
            } 
        }
        
        $this->model = load_model( $this->c );
    }

    public function is_logged_in(){
        return isset( $_SESSION[ 'current_user' ] );
    }

    public function load_view( $data = [], $view = '' ){

        extract( $data );
        require_once PATH . '/application/views/templates/head.php';
        echo '<div class="container-fluid">';
        echo '<div class="row">';
        if( !( 'user' == $this->c && 'index' == $this->m ) ){
            require_once PATH . '/application/views/templates/navbar.php';
            echo '</div>';
            echo '</div>';
            echo '<div class="container">';
            echo '<div class="row">';
            echo '<div class="col-4">';
            require_once PATH . '/application/views/templates/sidebar.php';
            echo '</div>';
        }
        ?>
            <div class="<?php echo(($view == 'login') ? 'col-12' : 'col-8'); ?>">
                <?php
                    $view = empty( $view ) ? $this->c : $view;
                    $view_path = PATH . '/application/views/' . $view . '_view.php';
                    if( file_exists( $view_path ) ){
                        require $view_path;
                    }else{
                        dd( $view . '_view.php does not exists' ); //dunmp and die function
                    }
                ?>
            </div>
        <?php
        echo '</div>';
        
        require_once PATH . '/application/views/templates/footer.php';
        echo '</div>';
    }

    public function logout(){
        session_unset();    
        //destroy the session
        session_destroy();
        redirect( 'user' );
    }

}