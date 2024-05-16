<?php

class Holiday_Controller extends Base_Controller{

    protected $post_methods = [ 'save' , 'delete' ];

    public function index(){ 
        $holidays = $this->model->get();
        $total = $this->model->get_count();

        $this->load_view( [ 
            'page_title' => 'Holiday',
            'holidays'   => $holidays,
            'total'      => $total,
            'modal' => [
                "title" => "Add / Update Holiday",
                "view"  => "holiday"
            ]
        ], 'holiday' ); 
    }

    public function details( $id ) {
        if ( !$id ) {
            redirect('holiday');
        }

        $details = $this->model->get(
            [ 'id' => $id ], 
            true
        );

        if (!$details) {
            redirect('holiday');
        }

        $this->load_view([
            'page_title'    => 'Holiday Details',
            'details' => $details,
        ], 'holiday_details');  
    }

    public function save() {

         $data = [
            'from_date' => $_POST[ 'from_date' ],
            'event' => $_POST[ 'event' ]
        ];
        if( isset( $_POST[ 'id'] ) && $_POST[ 'id' ] > 0 ){
            $data[ 'id' ] = $_POST[ 'id' ];
        }
        $this->model->save( $data );
        redirect( 'holiday' );
    }
    public function delete() {
        try {
            $holidayId = $_POST[ 'id' ];
            $deleted = $this->model->delete( $holidayId );
            if ( $deleted ) {
                echo json_encode( [ 'success' => true ] );
            } else {
                echo json_encode( [ 'success' => false, 'message' => 'Failed to delete holiday' ] );
            }
        } catch (Exception $e) {
            echo json_encode( [ 'success' => false, 'message' => 'Error: ' . $e->getMessage() ] );
        }
    }
}