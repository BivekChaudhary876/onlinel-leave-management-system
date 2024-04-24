<?php 
class Dashboard_Model extends Base_Model{

    protected $table = 'leave_requests';

    function getStatusBadge($status) {
    switch ($status) {
      case 'pending':
        return '<span class="badge text-bg-warning">Pending</span>';
      case 'approved':
        return '<span class="badge text-bg-success">Approved</span>';
      case 'rejected':
        return '<span class="badge text-bg-danger">Rejected</span>';
      default:
        return 'Status not available';
    }
  }

}

