
<?php

    class Dashboard_Controller extends Base_Controller{

        
        public function index(){

            if(! isset( $_SESSION[ 'current_user' ][ 'role' ]) && $_SESSION[ 'current_user' ][ 'role' ] == 'admin' ){
                header( "Location: index.php?c=user" );
                exit;
            }

            $usernames = $this->model->get_usernames();
            $leave_requests = $this->model->get();

            // Get the selected month
            $selected_month = isset($_POST['selected_month']) ? $_POST['selected_month'] : '';

            // Filter leave requests based on the selected month
            $filtered_leave_requests = array_filter($leave_requests, function($leave_request) use ($selected_month) {
                $start_date = strtotime($leave_request['startDate']);
                $month_year = date('F Y', $start_date);
                return $selected_month == $month_year;
            });
            usort($leave_requests, function($a, $b) {
                return strtotime($b['startDate']) - strtotime($a['startDate']);
            });

            // Initialize leave counts
            $totalLeaveCount = 0;
            $pendingLeaveCount = 0;
            $approvedLeaveCount = 0;
            $rejectedLeaveCount = 0;
            $totalLeaveDays = 0;

            // Initialize an array to store leave requests for the selected user
            $selectedUserLeaveRequests = [];
            $selected_user = '';
            
            if((isset( $_POST[ 'selected_user' ] ) ) ) {
                $selected_user = $_POST[ 'selected_user' ];
                foreach( $leave_requests as $p ) {
                    if( $selected_user == $p[ 'username' ] ) {
                        if( $p[ 'status' ] == 2 ) {
                        // Calculate the duration of the leave request
                        $startDate = new DateTime($p[ 'startDate' ]);
                        $endDate = new DateTime($p[ 'endDate' ]);
                        $duration = $endDate->diff( $startDate )->days + 1; // Add 1 to include both start and end dates

                        // Add the duration to the total leave days
                        $totalLeaveDays += $duration;
                        }
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
            }elseif( ( $_SESSION[ 'current_user' ][ 'role' ] == 'admin' ) ) {
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
        }
            
            else {
                foreach( $leave_requests as $p ){
                // Trim whitespace and convert to lowercase for comparison
                $leave_username = strtolower(trim( $p[ 'username' ] ) );
                $session_username = strtolower( trim( $_SESSION[ 'current_user' ][ 'username' ] ) );
                
                // Trim whitespace and convert to lowercase for comparison
                $leave_email = strtolower(trim( $p[ 'email' ] ) );
                $session_email = strtolower( trim( $_SESSION[ 'current_user' ][ 'email' ] ) );
                if ( ( $leave_username == $session_username && $leave_email == $session_email ) ) {
                    if( $p[ 'status' ] == 2){
                    $startDate = new DateTime( $p[ 'startDate' ] );
                    $endDate = new DateTime( $p[ 'endDate' ] );
                    $duration = $endDate->diff($startDate)->days + 1; // Add 1 to include both start and end dates

                    // Add the duration to the total leave days
                    $totalLeaveDays += $duration;
                    }
                    $totalLeaveCount++; 
                    if( $p[ 'status' ] == 1 ){
                        $pendingLeaveCount++;
                    }elseif($p[ 'status' ] == 2 ){
                        $approvedLeaveCount++;;
                    }elseif( $p[ 'status' ] == 3 ){
                        $rejectedLeaveCount++;
                    }
                }
                }
            }

            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_month'])) {
                $selectedMonth = $_POST['selected_month'];
                // Check if a month is selected
                if ($selectedMonth != "0") {
                    // Display the selected table
                    $display_normal_table = false;
                } else {
                    // Display the normal table
                    $display_normal_table = true;
                }
            } else {
                // Display the normal table by default
                $display_normal_table = true;
            }

            $this->load_view([
                'page_title' => 'Dashboard',
                'usernames' => $usernames,
                'leave_requests' => $leave_requests,
                'filtered_leave_requests' => $filtered_leave_requests,
                'totalLeaveCount' => $totalLeaveCount,
                'pendingLeaveCount' => $pendingLeaveCount,
                'approvedLeaveCount' => $approvedLeaveCount,
                'rejectedLeaveCount' => $rejectedLeaveCount,
                'selectedUserLeaveRequests' => $selectedUserLeaveRequests,
                'selected_user' => $selected_user,
                'totalLeaveDays' => $totalLeaveDays,
                'display_normal_table' => $display_normal_table
            ]);
        }


        public function logout(){
            parent::logout();
        }
        
    }