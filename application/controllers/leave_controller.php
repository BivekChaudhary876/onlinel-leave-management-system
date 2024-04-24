<?php

class Leave_Controller extends Base_Controller {

    protected $post_methods = ['save', 'delete'];

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $type_m = load_model( 'type' );
        $users = false;

        $where = $where_count = [];
        if( isset( $_POST[ 'selected_user' ] ) && !empty( $_POST[ 'selected_user' ] ) ){
           $where = [ 'lr.user_id' => $_POST[ 'selected_user' ] ];
           $where_count = [ 'user_id' => $_POST[ 'selected_user' ] ];
        }

        if( isset( $_POST[ 'selected_status' ] ) && !empty( $_POST[ 'selected_status' ] ) ){
           $where = [ 'lr.status' => $_POST[ 'selected_status' ] ];
        }

        if( isset( $_POST[ 'from_date' ] ) && $_POST[ 'from_date' ] ){
            $where[ 'DATE(lr.created_date) >'] = $_POST[ 'from_date' ];
            $where_count[ 'DATE(created_date) >'] = $_POST[ 'from_date' ];
        }

        if( isset( $_POST[ 'to_date' ] ) && $_POST[ 'to_date' ] ){
            $where[ 'DATE(lr.created_date) <'] = $_POST[ 'to_date' ];
            $where_count[ 'DATE(created_date) <'] = $_POST[ 'to_date' ];
        }

        if ( is_admin() ) {
            $user_m = load_model( 'user' );
            $users  = $user_m->get( [], false );
            $total  = $this->model->get_count( $where_count );
            

        } else {
            $where[ 'lr.user_id' ] = get_current_user_id();
            $total = $this->model->get_count([ 
                'user_id' => get_current_user_id()
            ]);
        }

        $leaves = $this->model->get( $where );
        
        $this->load_view([
            'users'       => $users,
            'page_title'  => 'Leave List',
            'leave_types' => $type_m->get(),
            'leaves'      => $leaves,
            'total'       => $total,
           
        ],'leave');
    }

    public function save() {

        if( isset( $_POST[ 'action' ] ) && ( $_POST[ 'action' ] == 'approve' || $_POST[ 'action' ] == 'reject' ) ) {
            // Retrieve the leave ID
            $id = $_POST[ 'id' ];
            // Set the status based on the action
            $status = ( $_POST[ 'action' ] == 'approve' ) ? 'approved' : 'rejected'; // 2 for Approved, 3 for Rejected
            
            $this->model->save([
                'id'     => $id,
                'status' => $status,
            ]);// Update the status in the database
           
            // Return the updated status
            echo ($status == 'approve') ? 'Approved' : 'Rejected';
            exit;
        } else {
            // Add logic for user_id and type_id
           $data = [
                'user_id'     => $_SESSION['current_user']['id'],
                'type_id'     => $_POST['leaveType'],
                'from_date'   => $_POST['from_date'],
                'to_date'     => $_POST['to_date'],
                'description' => $_POST['description'],
                'status'      => 'pending', // Default status: Pending
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











