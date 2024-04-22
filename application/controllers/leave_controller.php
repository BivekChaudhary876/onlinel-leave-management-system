<?php

class Leave_Controller extends Base_Controller {

    protected $post_methods = ['save', 'delete'];

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Retrieve leave requests along with user and type information
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

    public function save() {
        if (isset($_POST['action']) && ($_POST['action'] == 'approve' || 'reject')) {
            $leaveId = $_POST['id'];
            $status = ($_POST['action'] == 'approve') ? 2 : 3;
            $this->model->updateStatus($leaveId, $status);
            echo ($status == 2) ? 'Approved' : 'Rejected';
            exit;
        } else {
            // Add logic for user_id and type_id
            $data = [
                'user_id' => $_SESSION['current_user']['id'],
                'type_id' => $_POST['type_id'],
                'from' => $_POST['from'],
                'to' => $_POST['to'],
                'description' => $_POST['description'],
                'status' => 1, // Default status: Pending
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











