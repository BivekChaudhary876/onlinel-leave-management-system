<?php
class Leave_Model extends Base_Model{
    
    protected $table = 'leave_requests';

    public function get( $conditions=[], $columns=[]){

        $sql ="
            SELECT 
                lr.id AS leave_request_id,
                lr.user_id,
                u.username,
                u.email,
                u.department,
                lr.type_id,
                lt.type AS leave_type,
                lr.from,
                lr.to,
                lr.description,
                lr.status
            FROM 
                {$this->table} lr
            INNER JOIN 
                users u
            ON 
                lr.user_id = u.id
            INNER JOIN 
                types lt
            ON 
                lr.type_id = lt.id

                ";

         if( !empty( $conditions ) ){
            $sql .= ' WHERE ';
            foreach( $conditions as $key => $value ){
                $sql .= "$key= '" . $this->db->escape( $value ) ."' AND ";
            }

            $sql = rtrim( $sql, 'AND ');
        }

        // dd( $sql   );
        $sql .= ' ORDER BY lr.id ASC';

        try {
            // Execute the query and fetch results as an associative array
            $result = $this->db->query($sql);
            return $this->db->fetch($result);
        } catch (mysqli_sql_exception $e) {
            // Handle exception and return false in case of an error
            error_log("Error retrieving leave requests: " . $e->getMessage());
            return false;
        }
    }
    // Functions to determine status badge
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