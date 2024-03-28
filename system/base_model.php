<?php
abstract class Base_Model{

    protected $table;

    protected $db;

    public function __construct(){
        $this->db = Conn::get_instance();
    }

    public function get( $columns = [] ){
       $result = $this->db->query( "SELECT * FROM {$this->table}" );
       return $this->db->fetch($result);
    }

    public function save(){

    }

    public function delete(){

    }
}