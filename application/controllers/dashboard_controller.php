
<?php
    class Dashboard_Controller extends Base_Controller{

        public function index(){

            if(! isset( $_SESSION[ 'username' ] ) ){
                header("Location: login_view.php");
                exit;
            }
            $this->load_view() ;
        }
    }