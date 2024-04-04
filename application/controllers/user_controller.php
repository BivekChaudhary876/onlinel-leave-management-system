<?php 

class User_Controller extends Base_Controller{

    protected $post_methods = [ 'login', 'save', 'getUser', 'updateUser', 'deleteUser' ];

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

    public function getUser(){
    $id = $_POST['id'];
    $columns = ['id'];
    $user = $this->model->get_single( ['id' => $id], $columns );
    echo json_encode($user); // Return the user data as JSON
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
    // Method to handle updating a user
    public function updateUser() {
        // Retrieve data sent via POST request
        $userId = $_POST['userId'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Perform validation on input data if necessary

        // Update user data in the database
        $updated = $this->model->update( $userId, ['username' => $username, 'email' => $email, 'password' => $password] );

        // Send response back to the client
        if ( $updated ) {
            echo json_encode( ['success' => true] );
        } else {
            echo json_encode( ['success' => false, 'message' => 'Failed to update user data'] );
        }
    }


    // Method to handle deleting a user
    public function deleteUser() {
        try {
            // Retrieve user ID sent via POST request
            $userId = $_POST['userId'];

            // Delete user data from the database
            $deleted = $this->model->delete($userId);

            // Send response back to the client
            if ($deleted) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
            }
        } catch (Exception $e) {
            // Log or handle the exception
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }




}