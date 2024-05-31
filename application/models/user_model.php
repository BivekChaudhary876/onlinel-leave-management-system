<?php
class User_Model extends Base_Model {

    protected $table = 'users';

    protected $columns = [ 'u.*', 'd.name as department' ];

    public function get( $conditions = [], $pagination = true, $args = [] ) {
        $this->db->select($this->columns, $this->table . " u");
        $this->db->join("departments d", "d.id = u.department_id");

        // Modify conditions to add table alias
        $modified_conditions = [];
        foreach ( $conditions as $key => $value ) {
            $modified_conditions["u.$key"] = $value;
        }

        $this->db->where( $modified_conditions );
        $this->db->order_by( 'u.created_date' );

        if ($pagination) {
            $this->db->paginate();
        }

        $result = $this->db->exec();
        return $this->db->fetch( $result );
    }

    public function get_by_upcoming_birthdays() {
        $users = $this->get( [], true, [
            'order_by' => 'CONCAT(SUBSTR( `birth_date`,6 ) < SUBSTR( CURDATE(), 6 ), SUBSTR( `birth_date`, 6 ) )',
            'order' => 'ASC'
        ] );

        return $users;
    }
}
