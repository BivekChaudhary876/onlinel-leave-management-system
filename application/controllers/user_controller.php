<?php 

class User_Controller extends Base_Controller{

    protected $post_methods = [ 'login', 'save', 'deleteUser' ];

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
                // Redirect based on user's role
                if ( $user[0] ) {
                    redirect( 'dashboard' ); // Redirect admin to dashboard
                } else {
                    redirect( 'user' ); // Redirect regular user to user list
                }
            }
        }  

        $this->index();
    }

    public function list(){
        $users = $this->model->get();
        
        $this->load_view( [ 
            'page_title' => 'User List',
            'users' => $users
        ], 'user_lists' );
    }
    
    public function save(){
        
        $data = [
            'username' => $_POST[ 'username' ], 
            'email'    => $_POST[ 'email' ], 
            'department' => $_POST[ 'department' ],
            'password' => $_POST[ 'password' ]

        ];
        if( isset( $_POST[ 'id' ] ) && $_POST[ 'id' ] > 0 ){ //update
            $data[ 'id' ] = $_POST[ 'id' ];
        }
        $this->model->save( $data );

        redirect( 'user' , 'list');
    }

    // Method to handle deleting a user
    public function deleteUser() {
        try {
            $userId = $_POST['userId'];
            $deleted = $this->model->delete($userId);
            if ($deleted) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    
}