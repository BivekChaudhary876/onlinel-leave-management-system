<?php 

class Type_Controller extends Base_Controller{

    protected $post_methods = [ 'save' , 'delete' ];

    public function index(){
        $types = $this->model->get();
        $total_data  = $this->model->get_count();

        $this->load_view( [ 
            'page_title' => 'Type',
            'types' => $types,
            'total_data' => $total_data
        ], 'type' );
    }

    public function save(){
        $data = [
            'name' => $_POST[ 'name' ]
        ];
        if( isset( $_POST[ 'id'] ) && $_POST[ 'id' ] > 0 ){
                $data[ 'id' ] = $_POST[ 'id' ];
        }

        $this->model->save( $data );
        redirect( 'type' );

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