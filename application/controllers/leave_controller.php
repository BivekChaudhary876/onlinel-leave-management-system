<?php 

class Leave_Controller extends Base_Controller{

    protected $post_methods = ['save','delete'];

    public function __contruct(){
        parent::__contruct();
    }


    public function index(){
        if(! isset( $_SESSION[ 'current_user' ] ) ){
            header( "Location: index.php?c=user" );
            exit;
        }
    }


    public function list(){
        $leave = $this->model->get();

        $this->load_view([
            'page_title' => 'Leave List',
            'leave_requests' => $leave
        ], 'leave');
    }

    public function save(){
        $data = [
            'type' => $_POST[ 'type' ],
            'startDate' => $_POST[ 'startDate' ],
            'endDate' => $_POST[ 'endDate' ],
            'description' => $_POST[ 'description' ],
            'status' => $_POST[ 'status' ]
        ];
        
        if( isset( $_POST[ 'id' ] ) && $_POST[ 'id' ] > 0 ){ // Update an existing leave request
            $data[ 'id' ] = $_POST[ 'id' ];
        }

        $this->model->save( $data );
        redirect('leave', 'list');
    }

    public function delete() {
        try {
            $leaveId = $_POST[ 'id' ];
            $deleted = $this->model->delete( $leaveId );
            if ( $deleted ) {
                echo json_encode( [ 'success' => true ] );
            } else {
                echo json_encode( [ 'success' => false, 'message' => 'Failed to delete leave' ] );
            }
        } catch (Exception $e) {
            echo json_encode( [ 'success' => false, 'message' => 'Error: ' . $e->getMessage() ] );
        }
    }
}