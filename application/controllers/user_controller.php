<?php 

class User_Controller extends Base_Controller{

    protected $post_methods = [ 'login', 'save' ];

    public function index(){
        $this->load_view( [], 'login' );
    }

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
                $_SESSION[ 'current_user' ] = $user[ 0 ];
                if ( $user[0] ) {
                    redirect( 'dashboard' ); 
                } else {
                    redirect( 'user' ); 
                }
            }
        }  

        $this->index();
    }
    
    public function list( $id = false  ){
        $department_m = load_model('department');
        $departments = false;

        if( !is_admin() ){
            redirect( "dashboard" );
        }

        $where = [];
        $departments = $department_m->get( [], false );
        $data = [ 
            'page_title' => 'User List', 
            'departments' => $departments,
            'modal' => [
                "title" => "Add / Update User",
                "view"  => "user"
            ] 
        ];

        $view = 'user';
        if( $id ){
            # show only on user
            $where[ 'id' ] = $id;
            $view = 'user_details';
        }else{
            # list all the users
            $total = $this->model->get_count();
            $data[ 'total' ] = $total;
        }

        $users = $this->model->get( $where );
        $data[ 'users' ] = $users;
        
        $this->load_view( $data, $view );
    }
    
    public function save(){
        $department_id = isset( $_POST[ 'department_id' ] ) && $_POST[ 'department_id' ] !== '' ? $_POST[ 'department_id' ] : '';
        
        $data = [
            'username'   => $_POST[ 'username' ], 
            'email'      => $_POST[ 'email' ], 
            'gender'     => $_POST[ 'gender' ], 
            'birth_date' => $_POST[ 'birth_date' ], 
            'department_id' => $department_id,
            'address'    => $_POST[ 'address' ],
            'phone'      => $_POST[ 'phone' ],
            'password'   => $_POST[ 'password' ]
        ];
        if( isset( $_POST[ 'id' ] ) && $_POST[ 'id' ] > 0 ){ //update
            $data[ 'id' ] = $_POST[ 'id' ];
        }
        $this->model->save( $data );

        redirect( 'user' , 'list');
    }

    // Method to handle deleting a user
    public function delete() {
        try {
            $userId = $_POST['id'];
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