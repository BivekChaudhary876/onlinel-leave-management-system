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
                $sql .= $column . '=?,';
            }
        }

        $sql = rtrim( $sql, ',' );

        if( $id ){
            $sql .= ' WHERE id=?';
        }

        // Executing the SQL query with positional placeholders
        return $this->db->executeBuilder( $sql, $values );
    }

    public function updateStatus($id, $status) {
        try {
            // Construct SQL query for updating status
            $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
            
            // Execute the SQL query with status and ID as parameters
            $updated = $this->db->executeBuilder($sql, [$status, $id]);
            
            return $updated;
        } catch (Exception $e) {
            // Log or handle the exception
            echo "Error updating status: " . $e->getMessage();
            return false;
        }
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


}