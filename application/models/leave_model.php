<?php
class Leave_Model extends Base_Model{
    
    protected $table = 'leave_requests';
    protected $columns = [ 'lr.*', 'u.username', 'u.email', 'u.department', 'lr.type_id', 't.name as leave_type' ];

    public function get( $conditions=[], $pagination=true, $args = [] ){

        $this->db->select( $this->columns, $this->table . " lr");
        $this->db->join( "users u", "u.id = lr.user_id" );
        $this->db->join( "types t", "t.id = lr.type_id" );
        $this->db->where( $conditions );
        $this->db->order_by( 'lr.created_date' );

        if( $pagination ){
            $this->db->paginate();
        }

        $result = $this->db->exec();
        return $this->db->fetch( $result );
    }    
}