<?php
class Dashboard_Controller extends Base_Controller {
    public function index() {

        $leave_m = load_model( 'leave' );
        $user_m  = load_model( 'user' );
        
        $where = [];
        if( isset( $_POST[ 'selected_user' ] ) && !empty( $_POST[ 'selected_user' ] ) ){
           $where = [ 'lr.user_id' => $_POST[ 'selected_user' ] ];
        }

        if( isset( $_POST[ 'from_date' ] ) && $_POST[ 'from_date' ] ){
            $where[ 'DATE(lr.created_date) >'] = $_POST[ 'from_date' ];
        }

        if( isset( $_POST[ 'to_date' ] ) && $_POST[ 'to_date' ] ){
            $where[ 'DATE(lr.created_date) <'] = $_POST[ 'to_date' ];
        }

        $leave_requests = $leave_m->get( $where );

        if ( is_admin() ) {

            $total_leave_status  = $leave_m->get_count();
            $pending_status  = $leave_m->get_count(['status' => 'pending']);
            $approved_status = $leave_m->get_count(['status' => 'approved']);
            $rejected_status = $leave_m->get_count(['status' => 'rejected']);

        } else {

            $current_user_id = $_SESSION['current_user']['id'];

            $total_leave_status  = $leave_m->get_count([
                'user_id'   => $current_user_id
            ]);
            
            $pending_status  = $leave_m->get_count([
                'status'  => 'pending', 
                'user_id' => $current_user_id 
            ]);

            $approved_status = $leave_m->get_count([
                'status'  => 'approved', 
                'user_id' => $current_user_id
            ]);

            $rejected_status = $leave_m->get_count([
                'status'  => 'rejected', 
                'user_id' => $current_user_id
            ]);

        }

        // Pass data to the view
        $this->load_view([
            'users'              => $user_m->get(),
            'page_title'         => 'Leave List',
            'leave_requests'     => $leave_requests,
            'total_leave_status' => $total_leave_status,
            'pending_status'     => $pending_status,
            'approved_status'    => $approved_status,
            'rejected_status'    => $rejected_status
        ], 'dashboard');
    }

    public function logout() {
        parent::logout();
    }
}
