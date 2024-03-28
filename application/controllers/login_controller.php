<?php 
class Login_Controller extends Base_Controller{

    public function __construct(){
        parent::__construct();

        $data = $this->model->get();
        $this->load_view( $data );
    }
}