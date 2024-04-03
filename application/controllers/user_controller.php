<?php 

class User_Controller extends Base_Controller{

    protected $post_methods = [ 'login', 'save' ];

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load_view( [], 'login' );
    }

    // method post
    public function login(){

        if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $where = [ 
                'username' => $username, 
                'password' => $password
            ];

            $user = $this->model->get( $where );
            if( empty( $user ) ){
                redirect( 'user' );
            } else {
                //user exists
                $_SESSION[ 'current_user' ] = $user[ 0 ];
                redirect( 'dashboard' );
            }
        }  

        $this->index();
    }

    public function list(){
        $users = $this->model->get();
        $this->load_view( [ 'page_title' => 'User List',
         'users' => $users ], 'user_lists' );
    }

    public function save(){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $columns =['username', 'email', 'password'];
        $inserted = $this->model->insert( [ 'username' => $username, 'email' => $email, 'password' => $password ], $columns );
        if( $inserted ){
            redirect( 'user' );
        }
       
    }
}