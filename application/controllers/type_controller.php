<?php 

class Type_Controller extends Base_Controller{

    protected $post_methods = [ 'save' , 'delete' ];

    public function __construct(){
        if( !is_admin() ){
            redirect( "dashboard" );
        }

        parent::__construct();
    }

    public function index(){
        $types = $this->model->get();
        $total  = $this->model->get_count();

        $this->load_view( [ 
            'page_title' => 'Type',
            'types'      => $types,
            'total'      => $total,
            'modal' => [
                "title" => "Add / Update Leave Type",
                "view"  => "leave_type"
            ]
        ], 'type' );
    }

    public function details( $id ){
        if ( !$id ) {
            redirect('type');
        }

        $details = $this->model->get(
            [ 'id' => $id ], 
            true
        );

        if (!$details) {
            redirect('type');
        }

        $this->load_view([
            'page_title'    => 'Leave Type Details',
            'details' => $details,
        ], 'type_details');  
    }

    public function save(){
        // $data = [
        //     'name' => $_POST[ 'name' ]
        // ];
        // if( isset( $_POST[ 'id'] ) && $_POST[ 'id' ] > 0 ){
        //     $data[ 'id' ] = $_POST[ 'id' ];
        // }
        // $this->model->save( $data );
        // redirect( 'type' );

        $valid_data = [ 'id', 'name' ];
        $data = [];
        foreach( $valid_data as $d ){
            if( isset( $_POST[ $d ] ) ){
                $data[ $d ] = $_POST[ $d ];
            }
        }
        
        // Check if 'id' is set and greater than 0, indicating an update
        if ( isset( $_POST[ 'id' ] ) && $_POST[ 'id' ] > 0 ) {
        // Update the existing leave record
            $data[ 'id' ] = $_POST[ 'id' ];
            $this->model->save( $data );
        } else {
        // Remove 'id' from data if it's set to ensure a new record is created
            unset($data['id']);
        // Add a new leave record
            $this->model->save($data);
        }
        redirect('type');
    }
    public function delete() {
        try {
            $id = $_POST[ 'id' ];
            $deleted = $this->model->delete( $id );
            if ( $deleted ) {
                echo json_encode( [ 'success' => true ] );
            } else {
                echo json_encode( [ 'success' => false, 'message' => 'Failed to delete type' ] );
            }
        } catch (Exception $e) {
            echo json_encode( [ 'success' => false, 'message' => 'Error: ' . $e->getMessage() ] );
        }
    }
}