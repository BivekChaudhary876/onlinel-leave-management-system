<?php 
class User_Model extends Base_Model{

    protected $table = 'users';

    public function get_by_upcoming_birthdays(){
        $users = $this->get( [], true, [ 
            'order_by' => 'CONCAT( SUBSTR( `birth_date`,6 ) < SUBSTR( CURDATE(), 6 ), SUBSTR( `birth_date`, 6 ) )', 
            'order'    => 'ASC' 
        ]);

        return $users;
    }
}


