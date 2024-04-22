
<?php

    class Dashboard_Controller extends Base_Controller{

        
        public function index(){
         $leave_requests = $this->model->get_leave_requests_with_user_and_type();
        usort($leave_requests, function($a, $b) {
            return strtotime($b['from']) - strtotime($a['from']);
        });

        // Initialize leave counts
        $totalLeaveCount = 0;
        $pendingLeaveCount = 0;
        $approvedLeaveCount = 0;
        $rejectedLeaveCount = 0;
        $totalLeaveDays = 0;

        if ($_SESSION['current_user']['role'] == 'admin') {
            foreach ($leave_requests as $p) {
                $from = new DateTime($p['from']);
                $to = new DateTime($p['to']);
                $duration = $to->diff($from)->days + 1; // Include both start and end dates

                $totalLeaveDays += $duration;
                $totalLeaveCount++;
                if ($p['status'] == 1) {
                    $pendingLeaveCount++;
                } elseif ($p['status'] == 2) {
                    $approvedLeaveCount++;
                } elseif ($p['status'] == 3) {
                    $rejectedLeaveCount++;
                }
            }
        } else {
            foreach ($leave_requests as $p) {
                if ($p['user_id'] == $_SESSION['current_user']['id']) {
                    $totalLeaveCount++;
                    if ($p['status'] == 1) {
                        $pendingLeaveCount++;
                    } elseif ($p['status'] == 2) {
                        $approvedLeaveCount++;
                    } elseif ($p['status'] == 3) {
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
        ],'leave');
        }


        public function logout(){
            parent::logout();
        }
        
    }