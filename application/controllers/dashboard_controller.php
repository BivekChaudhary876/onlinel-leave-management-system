
<?php

    class Dashboard_Controller extends Base_Controller{

        public function index(){

            if(! isset( $_SESSION[ 'current_user' ] ) ){
                header("Location: index.php?c=user");
                exit;
            }

            $this->load_view([
                'page_title' => 'Dashboard', 
                'users' => []
            ]);
        }
        public function logout(){
            parent::logout();
        }
        
    }