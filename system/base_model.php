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

    public function save(){

    }

    public function delete(){

    }
}