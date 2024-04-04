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

       $result = $this->db->query( $sql );
       return $this->db->fetch($result);
    }


    public function get_single($conditions = [], $columns = []) {
        $sql = "SELECT";

        if (!empty($columns)) {
            $sql .= ' ' . implode(',', $columns);
        } else {
            $sql .= ' *';
        }

        $sql .= " FROM {$this->table}";

        if (!empty($conditions)) {
            $sql .= ' WHERE ';
            foreach ($conditions as $key => $value) {
                $sql .= "$key = '" . $this->db->escape($value) . "' AND ";
            }
            $sql = rtrim($sql, 'AND ');
        }

        $sql .= " LIMIT 1"; // Limit the result to one row

        $result = $this->db->query($sql);
        return $this->db->fetch($result);
    }



    public function insert( $conditions = [], $columns ) {

        $sql = "INSERT INTO {$this->table} (" . implode( ", ", $columns ) . ") VALUES (" . rtrim(str_repeat( "?, ", count( $columns ) ), ", ") . ")";

        $values = array_values( $conditions );

        // Executing the SQL query with positional placeholders
        return $this->db->executeBuilder( $sql, $values );
    }



    public function update( $userId, $data ) {
        // Construct SQL query for updating user data
        $columnsToUpdate = [];
        $values = [];
        foreach ( $data as $column => $value ) {
            $columnsToUpdate[] = "$column = ?";
            $values[] = $value;
        }
        $values[] = $userId;
        $sql = "UPDATE {$this->table} SET " . implode(", ", $columnsToUpdate) . " WHERE id = ?";
        // Execute the SQL query with positional placeholders
        return $this->db->executeBuilder(   $sql, $values );
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