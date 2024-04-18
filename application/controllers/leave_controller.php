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
        $leave_requests = $this->model->get();
         // Initialize leave counts
        $totalLeaveCount = 0;
        $pendingLeaveCount = 0;
        $approvedLeaveCount = 0;
        $rejectedLeaveCount = 0;
        $totalLeaveDays = 0;

        
        if( ( $_SESSION[ 'current_user' ][ 'role' ] == 'admin' ) ) {
            foreach( $leave_requests as $p ) {
                // Calculate the duration of the leave request
                $startDate = new DateTime( $p[ 'startDate' ] );
                $endDate = new DateTime( $p[ 'endDate' ] );
                $duration = $endDate->diff($startDate)->days + 1; // Add 1 to include both start and end dates

                // Add the duration to the total leave days
                $totalLeaveDays += $duration;
                $totalLeaveCount++;
                if( $p[ 'status' ] == 1 ) {
                    $pendingLeaveCount++;
                } elseif( $p[ 'status' ] == 2 ) {
                    $approvedLeaveCount++;
                } elseif( $p[ 'status' ] == 3 ) {
                    $rejectedLeaveCount++;
                }
            }
        }else {
            foreach( $leave_requests as $p ){
            // Trim whitespace and convert to lowercase for comparison
            $leave_username = strtolower( trim( $p[ 'username' ] ) );
            $session_username = strtolower( trim( $_SESSION[ 'current_user' ][ 'username' ] ) );
            
            // Trim whitespace and convert to lowercase for comparison
            $leave_email = strtolower( trim( $p[ 'email' ] ) );
            $session_email = strtolower( trim( $_SESSION[ 'current_user' ][ 'email' ] ) );
            if ( ( $leave_username == $session_username && $leave_email == $session_email ) ) {
                $totalLeaveCount++; 
                if( $p[ 'status' ] == 1){
                    $pendingLeaveCount++;
                }elseif($p[ 'status' ] == 2){
                    $approvedLeaveCount++;;
                }elseif( $p[ 'status' ] == 3 ){
                    $rejectedLeaveCount++;
                }
            }
            }
        }

        $this->load_view([
            'page_title' => 'Leave List',
            'leave_requests' => $leave_requests,
            'totalLeaveCount' => $totalLeaveCount,
            'pendingLeaveCount' => $pendingLeaveCount,
            'approvedLeaveCount' => $approvedLeaveCount,
            'rejectedLeaveCount' => $rejectedLeaveCount,
            'totalLeaveDays' => $totalLeaveDays
        ], 'leave');
    }

    public function save(){
    // Check if an action (approve or reject) is specified
        if( isset( $_POST[ 'action' ] ) && ( $_POST[ 'action' ] == 'approve' || $_POST[ 'action' ] == 'reject' ) ) {
            // Retrieve the leave ID
            $leaveId = $_POST[ 'id' ];
            // Set the status based on the action
            $status = ( $_POST[ 'action' ] == 'approve' ) ? 2 : 3; // 2 for Approved, 3 for Rejected
            // Update the status in the database
            $this->model->updateStatus( $leaveId, $status );
            // Return the updated status
            echo ($status == 2) ? 'Approved' : 'Rejected';
            exit;
        } else {
            // Handle regular leave request saving here
            $data = [
                'username' => $_POST[ 'username' ],
                'email' => $_POST[ 'email' ],
                'department' => $_POST[ 'department' ],
                'type' => $_POST[ 'type' ],
                'startDate' => $_POST[ 'startDate' ],
                'endDate' => $_POST[ 'endDate' ],
                'description' => $_POST[ 'description' ],
                'status' => 1 // Default status: Pending
            ];
            
            if(isset( $_POST[ 'id' ] ) && $_POST[ 'id' ] > 0){ // Update an existing leave request
                $data[ 'id' ] = $_POST[ 'id' ];
            }

            $this->model->save($data);

            header('Location: index.php?c=leave&m=list');
            exit; 
        }
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
