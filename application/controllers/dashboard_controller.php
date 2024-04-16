
<?php

    class Dashboard_Controller extends Base_Controller{

        
        public function index(){

            if(! isset( $_SESSION[ 'current_user' ]['role']) && $_SESSION['current_user']['role']=='admin' ){
                header( "Location: index.php?c=user" );
                exit;

            }

            $usernames = $this->model->get_usernames();
            $leave_requests = $this->model->get();

            // Initialize leave counts
            $totalLeaveCount = 0;
            $pendingLeaveCount = 0;
            $approvedLeaveCount = 0;
            $rejectedLeaveCount = 0;

            // Initialize an array to store leave requests for the selected user
            $selectedUserLeaveRequests = [];
            $selected_user = '';
            
            if((isset( $_POST[ 'selected_user' ] ) ) ) {
                $selected_user = $_POST[ 'selected_user' ];
                foreach( $leave_requests as $p ) {
                    if( $selected_user == $p[ 'username' ] ) {
                        $totalLeaveCount++;
                        if( $p[ 'status' ] == 1 ) {
                            $pendingLeaveCount++;
                        } elseif( $p[ 'status' ] == 2 ) {
                            $approvedLeaveCount++;
                        } elseif( $p[ 'status' ] == 3 ) {
                            $rejectedLeaveCount++;
                        }
                        // Add the leave request to the selected user's leave requests array
                        $selectedUserLeaveRequests[] = $p;
                    }
                }
            }else {
                foreach( $leave_requests as $p ){
                // Trim whitespace and convert to lowercase for comparison
                $leave_username = strtolower(trim( $p[ 'username' ] ) );
                $session_username = strtolower( trim( $_SESSION[ 'current_user' ][ 'username' ] ) );
                
                // Trim whitespace and convert to lowercase for comparison
                $leave_email = strtolower(trim( $p[ 'email' ] ) );
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
                'page_title' => 'Dashboard',
                'usernames' => $usernames,
                'leave_requests' => $leave_requests,
                'totalLeaveCount' => $totalLeaveCount,
                'pendingLeaveCount' => $pendingLeaveCount,
                'approvedLeaveCount' => $approvedLeaveCount,
                'rejectedLeaveCount' => $rejectedLeaveCount,
                'selectedUserLeaveRequests' => $selectedUserLeaveRequests,
                'selected_user' => $selected_user
            ]);
        }

        public function logout(){
            parent::logout();
        }
        
    }