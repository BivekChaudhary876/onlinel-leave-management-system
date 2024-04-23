<?php
abstract class Base_Model{

    protected $table;

    protected $db;

    public function __construct(){
        $this->db = Conn::get_instance();
    }

    public function get( $conditions = [], $columns = [] ){

       $sql = "SELECT";

       if( !empty( $columns )){
        $sql .= implode( ',', $columns );
       }else{
        $sql .= '*';
       }

       $sql .= "FROM {$this->table}";

        if( !empty( $conditions ) ){
            $sql .= ' WHERE ';
            foreach( $conditions as $key => $value ){
                $sql .= "$key= '" . $this->db->escape( $value ) ."' AND ";
            }

            $sql = rtrim( $sql, 'AND ');
        }

        $sql .= ' ORDER BY id ASC';

       $result = $this->db->query( $sql );
       return $this->db->fetch($result);
    }

    public function get_count( $conditions = [] ){

       $sql = "SELECT COUNT(*) c FROM {$this->table}";

        if( !empty( $conditions ) ){
            $sql .= ' WHERE ';
            foreach( $conditions as $key => $value ){
                $sql .= "$key= '" . $this->db->escape( $value ) ."' AND ";
            }

            $sql = rtrim( $sql, 'AND ');
        }

        $sql .= ' ORDER BY id ASC';

       $result = $this->db->query( $sql );
       return $this->db->fetch_row($result);
    }


    public function save( $data = [] ) {

        $id = false;
        $values = array_values( $data );
        if( isset( $data[ 'id' ] ) ){
            $id = $data[ 'id' ];
            $sql = 'UPDATE';
        }else{
            $sql = 'INSERT INTO';
        }

        $sql .= ' ' . $this->table . ' SET ';

        foreach( $data as $column => $value ){
            if( 'id' != $column ){
                $sql .= '`' . $column . '` =?,';
            }
        }

        $sql = rtrim( $sql, ',' );

        if( $id ){
            $sql .= ' WHERE id=?';
        }

        // Executing the SQL query with positional placeholders
        return $this->db->executeBuilder( $sql, $values );
    }

    public function delete( $userId ) {
        try {
            // Construct SQL query for deleting user
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
        
            // Execute the SQL query with user ID as parameter
            $deleted = $this->db->executeBuilder( $sql, [$userId] );
            
            return $deleted;
        } catch ( Exception $e ) {
            // Log or handle the exception
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }
    }

    public function get_leave_types() {
        $sql = "SELECT DISTINCT `type` FROM {$this->table}";
        $result = $this->db->query($sql);

        $usernames = array();

        if ($result) {
            // Fetch usernames and store them in an array
            while($row = $result->fetch_assoc()) {
                $usernames[] = $row['type'];
            }
            // Free result set
            $result->free();
        }

        return $usernames;
    }

//     public function get_leave_requests_with_user_and_type($conditions = []) {
//         $sql = "
//             SELECT 
//                 lr.id AS leave_request_id,
//                 lr.user_id,
//                 u.username,
//                 u.email,
//                 u.department,
//                 lr.type_id,
//                 lt.type AS leave_type,
//                 lr.from,
//                 lr.to,
//                 lr.description,
//                 lr.status
//             FROM 
//                 leave_requests lr
//             INNER JOIN 
//                 users u
//             ON 
//                 lr.user_id = u.id
//             INNER JOIN 
//                 types lt
//             ON 
//                 lr.type_id = lt.id
//         ";

//         // Append conditions to the query
//         if (!empty($conditions)) {
//             $sql .= " WHERE ";
//             foreach ($conditions as $key => $value) {
//                 // Using escape method to prevent SQL injection
//                 $sql .= "$key = '" . $this->db->escape($value) . "' AND ";
//             }
//             $sql = rtrim($sql, " AND "); // Remove trailing "AND"
//         }

//         // Add ordering by 'from' date in descending order
//         $sql .= " ORDER BY lr.from DESC";

//         try {
//             // Execute the query and fetch results as an associative array
//             $result = $this->db->query($sql);
//             return $this->db->fetch($result);
//         } catch (mysqli_sql_exception $e) {
//         // Handle exception and return false in case of an error
//         error_log("Error retrieving leave requests: " . $e->getMessage());
//         return false;
//     }
// }


    public function updateStatus($id, $status) {
    try {
        // Prepare the SQL statement with positional placeholders
        $sql = "UPDATE " . $this->table . " SET status = ? WHERE id = ?";

        // Execute the SQL query with the provided status and id
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $status, $id); // 'ii' indicates both parameters are integers

        $stmt->execute(); // Execute the prepared statement
        
        return $stmt->affected_rows > 0; // Return true if at least one row was affected
    } catch (mysqli_sql_exception $e) {
        // Handle exception and return false in case of an error
        error_log("Error updating status: " . $e->getMessage());
        return false;
    } finally {
        if (isset($stmt)) {
            $stmt->close(); // Close the statement
        }
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