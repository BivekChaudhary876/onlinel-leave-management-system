<?php

class Leave_Controller extends Base_Controller {

    protected $post_methods = [ 'save', 'delete' ];

    public function index() {

        $type_m = load_model( 'type' );
        $user_m = load_model( 'user' );
        $users = false;

        $where = $where_count = [];
        if( isset( $_GET[ 'selected_user' ] ) && !empty( $_GET[ 'selected_user' ] ) ){
           $where = [ 'lr.user_id' => $_GET[ 'selected_user' ] ];
           $where_count = [ 'user_id' => $_GET[ 'selected_user' ] ];
        }

        if( isset( $_GET[ 'selected_status' ] ) && !empty( $_GET[ 'selected_status' ] ) ){
           $where = [ 'lr.status' => $_GET[ 'selected_status' ] ];
        }

        if( isset( $_GET[ 'from_date' ] ) && $_GET[ 'from_date' ] ){
            $where[ 'DATE(lr.created_date) >'] = $_GET[ 'from_date' ];
            $where_count[ 'DATE(created_date) >'] = $_GET[ 'from_date' ];
        }

        if( isset( $_GET[ 'to_date' ] ) && $_GET[ 'to_date' ] ){
            $where[ 'DATE(lr.created_date) <' ] = $_GET[ 'to_date' ];
            $where_count[ 'DATE(created_date) <' ] = $_GET[ 'to_date' ];
        }

        if ( is_admin() ) {
            $users  = $user_m->get( [], false );
            $total  = $this->model->get_count( $where_count );
        } else {
            $where[ 'lr.user_id' ] = get_current_user_id();
            $where_count[ 'user_id' ] = get_current_user_id();
            $total = $this->model->get_count( $where_count );
            $users  = $user_m->get( [ "id" => get_current_user_id() ], false );
        }

        $leaves = $this->model->get( $where );
        $leave_types  = $type_m->get( [], false );
        
        $this->load_view([
            'users'       => $users,
            'page_title'  => 'Leave List',
            'leave_types' => $leave_types,
            'leaves'      => $leaves,
            'total'       => $total,
        ],'leave');
    }

    public function details( $id ) {
        if ( !$id ) {
            redirect('leave');
        }

        $details = $this->model->get(
            [ 'lr.id' => $id ], 
            true
        );

        if (!$details) {
            redirect('leave');
        }

        $this->load_view([
            'page_title'    => 'Leave Details',
            'details' => $details,
        ], 'leave_details');  
    }

    public function save() {

        $valid_data = [ 'id', 'user_id', 'type_id', 'from_date', 'to_date', 'description', 'status' ];
        $data = [];
        foreach( $valid_data as $d ){
            if( isset( $_POST[ $d ] ) ){
                $data[ $d ] = $_POST[ $d ];
            }
        }
   
        $this->model->save( $data );
        redirect( 'leave' );
    }

    public function delete() {
        try {
            $leaveId = $_POST['id'];
            $deleted = $this->model->delete( $leaveId );
            if ( $deleted ) {
                echo json_encode( ['success' => true] );
            } else {
                echo json_encode( ['success' => false, 'message' => 'Failed to delete leave'] );
            }
        } catch ( Exception $e ) {
            echo json_encode( ['success' => false, 'message' => 'Error: ' . $e->getMessage() ] );
        }
    }
}

?>











