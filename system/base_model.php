<?php
abstract class Base_Model{

    protected $table;

    protected $db;

    protected $columns = [];
    
    public function __construct(){
        $this->db = db();
    }

    public function get( $conditions = [], $pagination = true ){
        
        $this->db->select( $this->columns, $this->table );

        $this->db->where( $conditions );

        $this->db->order_by();

        if( $pagination ){
            $this->db->paginate();
        }

       $result = $this->db->exec();
       return $this->db->fetch($result);
    }

    public function get_count( $conditions = [] ){

        $this->db->select( [ "COUNT(*) c" ], $this->table );
        $this->db->where( $conditions );
        
        $result = $this->db->exec();
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
            $sql .= $column . ' = "' . $this->db->escape( $value ) .'",';
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
}