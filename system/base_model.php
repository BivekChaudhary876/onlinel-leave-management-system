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

        $sql .= ' ORDER BY id DESC';

       $result = $this->db->exec( $sql );
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

       $result = $this->db->exec( $sql );
       return $this->db->fetch_row($result);
    }


    public function save( $data = [] ) {

        $id = false;
        $values = array_values( $data );
        if( isset( $data[ 'id' ] ) ){
            $id = $data[ 'id' ];
            unset( $data[ 'id'] );
            $sql = 'UPDATE';
        }else{
            $sql = 'INSERT INTO';
        }

        $sql .= ' ' . $this->table . ' SET ';

        foreach( $data as $column => $value ){
            $sql .= $column . ' = "' . $value .'",';
        }

        $sql = rtrim( $sql, ',' );

        if( $id ){
            $sql .= ' WHERE id=' . $id;
        }
        // Executing the SQL query with positional placeholders
        return $this->db->exec( $sql );
    }

    public function delete( $id ) {
        try {
            // Construct SQL query for deleting user
            $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        
            // Execute the SQL query with user ID as parameter
            $deleted = $this->db->exec( $sql );
            
            return $deleted;
        } catch ( Exception $e ) {
            // Log or handle the exception
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }
    }

    public function get_leave_types() {
        $sql = "SELECT DISTINCT `type` FROM {$this->table}";
        $result = $this->db->exec($sql);

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
}