<?php
class Dashboard_Controller extends Base_Controller {
    public function index() {
        // $leave_requests = $this->model->get_leave_requests_with_user_and_type();

        $leave_m = load_model( 'leave' );
        $user_m  = load_model( 'user' );
        
        $where = [];
        if( isset( $_POST[ 'selected_user' ] ) && !empty( $_POST[ 'selected_user' ] ) ){
           $where = [ 'lr.user_id' => $_POST[ 'selected_user' ] ];
        }

        if( isset( $_POST[ 'from' ] ) && $_POST[ 'from' ] ){
            $where[ 'DATE(lr.created_date) >'] = $_POST[ 'from' ];
        }

        if( isset( $_POST[ 'to' ] ) && $_POST[ 'to' ] ){
            $where[ 'DATE(lr.created_date) <'] = $_POST[ 'to' ];
        }

        $leave_requests = $leave_m->get( $where );

        $is_admin = $_SESSION['current_user']['role']== 'admin';


        if ($is_admin) {

            $total_leave_status  = $this->model->get_count(['id']);
            $pending_status  = $this->model->get_count(['status' => 'pending']);
            $approved_status = $this->model->get_count(['status' => 'approved']);
            $rejected_status = $this->model->get_count(['status' => 'rejected']);

        } else {

            $current_user_id = $_SESSION['current_user']['id'];

            $total_leave_status  = $this->model->get_count([
                'user_id'   => $current_user_id
            ]);
            
            $pending_status  = $this->model->get_count([
                'status' => 'pending', 
                'user_id' => $current_user_id 
            ]);

            $approved_status = $this->model->get_count([
                'status' => 'approved', 
                'user_id' => $current_user_id
            ]);

            $rejected_status = $this->model->get_count([
                'status' => 'rejected', 
                'user_id' => $current_user_id
            ]);

        }

        // Pass data to the view
        $this->load_view([
            'users' => $user_m->get(),
            'page_title' => 'Leave List',
            'leave_requests' => $leave_requests,
            'total_leave_status' => $total_leave_status,
            'pending_status' => $pending_status,
            'approved_status' => $approved_status,
            'rejected_status' => $rejected_status
        ], 'dashboard');
    }

    public function logout() {
        parent::logout();
    }
}
