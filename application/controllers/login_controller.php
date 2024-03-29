<?php 
class Login_Controller extends Base_Controller{

    public function __construct(){
        parent::__construct();

        
    }

    public function index( $arg ){
        $this->load_view();
    }

    public function login(){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $where = [ 
            'username' => $_POST[ 'username' ], 
            'password' => $_POST[ 'password' ] 
        ];
       $user = $this->model->get( $where );

        // var_dump($user); die;

        if($this->authenticate( $_POST['username'], $_POST['password'] )){
            header("Location: index.php?c=dashboard");
            exit;
        }else { 
            header("Location: index.php?c=login&error=1");
            exit;
        }
    }



    private function authenticate( $username, $password ){
        if( $username === 'hi' &&  $password === 'hi'){
            $_SESSION['username'] = $username;
            return true;
        }else{
            return false;
        }
    }
}