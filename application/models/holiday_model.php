<?php
class Holiday_Model extends Base_Model{
    
    protected $table = 'holidays';

    public function get_by_upcoming_holidays(){
        $holidays = $this->get( [], true, [ 
            'order_by' => 'CONCAT( SUBSTR( `from_date`,6 ) < SUBSTR( CURDATE(), 6 ), SUBSTR( `from_date`, 6 ) )', 
            'order'    => 'ASC' 
        ]);

        return $holidays;
    }
    
}