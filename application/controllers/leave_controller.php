<?php

class Leave_Controller extends Base_Controller {

    protected $post_methods = ['save', 'delete'];

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $is_admin = $_SESSION['current_user']['role'] == 'admin';

        $type_m = load_model( 'type' );
        $user_m  = load_model( 'user' );
        // Retrieve leave requests along with user and type information
        $leave_requests = $type_m->get();

        // $leaves = $this->model->get();

        $where = [];
        if( isset( $_POST[ 'selected_user' ] ) && !empty( $_POST[ 'selected_user' ] ) ){
           $where = [ 'lr.user_id' => $_POST[ 'selected_user' ] ];
        }

        if( isset( $_POST[ 'selected_status' ] ) && !empty( $_POST[ 'selected_status' ] ) ){
           $where = [ 'lr.status' => $_POST[ 'selected_status' ] ];
        }

        if( isset( $_POST[ 'from' ] ) && $_POST[ 'from' ] ){
            $where[ 'DATE(lr.created_date) >'] = $_POST[ 'from' ];
        }

        if( isset( $_POST[ 'to' ] ) && $_POST[ 'to' ] ){
            $where[ 'DATE(lr.created_date) <'] = $_POST[ 'to' ];
        }

        $leaves = $this->model->get($where);
        $leaves_lists = $this->model->get();


        if ( $is_admin ) {

            $total_leave_status  = $this->model->get_count(['id']);
           
            $pending_status  = $this->model->get_count(['status' => 'pending']);
            $approved_status = $this->model->get_count(['status' => 'approved']);
            $rejected_status = $this->model->get_count(['status' => 'rejected']);

        } else {

            $current_user_id = $_SESSION['current_user']['id'];

            $total_leave_status  = $this->model->get_count(['id']);
            
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

        $this->load_view([
            'users' => $user_m->get(),
            'page_title' => 'Leave List',
            'leave_requests' => $leave_requests,
            'leaves' => $leaves,
            'total_leave_status' => $total_leave_status,
            'pending_status' => $pending_status,
            'approved_status' => $approved_status,
            'rejected_status' => $rejected_status
        ],'leave');
    }

    public function save() {

         
        if( isset( $_POST[ 'action' ] ) && ( $_POST[ 'action' ] == 'approve' || $_POST[ 'action' ] == 'reject' ) ) {
            // Retrieve the leave ID
            $leaveId = $_POST[ 'id' ];
            // Set the status based on the action
            $status = ( $_POST[ 'action' ] == 'approve' ) ? 'approved' : 'rejected'; // 2 for Approved, 3 for Rejected
            // Update the status in the database
            $this->model->updateStatus( $leaveId, $status );
            // Return the updated status
            echo ($status == 'approve') ? 'Approved' : 'Rejected';
            exit;
        } else {
            // Add logic for user_id and type_id
           $data = [
                'user_id' => $_SESSION['current_user']['id'],
                'type_id' => $_POST['type_id'],
                'from' => $_POST['from'],
                'to' => $_POST['to'],
                'description' => $_POST['description'],
                'status' => 'pending', // Default status: Pending
            ];

            if (isset($_POST['id']) && $_POST['id'] > 0) {
                $data['id'] = $_POST['id'];
            }

            $this->model->save($data);

            header('Location: index.php?c=leave');
            exit;
        }
    }

    public function delete() {
        try {
            $leaveId = $_POST['id'];
            $deleted = $this->model->delete($leaveId);
            if ($deleted) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete leave']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}

?>











