<?php 
class User_Model extends Base_Model{

    protected $table = 'users';

    protected $columns = [ 'user.*', 'd.name as department' ];

    public function get( $conditions = [], $pagination = true, $args = [] )
    {
        $this->db->select( $this->columns, $this->table . " user" );
        $this->db->join( "departments d", "d.id = user.department_id" );
        $this->db->where( $conditions );
        $this->db->order_by( 'user.created_date' );

        if ( $pagination ) {
            $this->db->paginate();
        }

        $result = $this->db->exec();
        return $this->db->fetch( $result );
    }


    public function get_by_upcoming_birthdays(){
        $users = $this->get( [], true, [ 
            'order_by' => 'CONCAT( SUBSTR( `birth_date`,6 ) < SUBSTR( CURDATE(), 6 ), SUBSTR( `birth_date`, 6 ) )', 
            'order'    => 'ASC' 
        ]);

        return $users;
    }
}


