<?php 

class Leave_Counter_Widget extends Base_Widget{

    protected $name = 'leave-counter';

    protected $icon = 'leave';

    protected $collapsible = 'collapsible';

    protected $uncollapsible = 'uncollapse';

    protected $id = 'leave-status';

    protected $title = 'Recent Leave Requests By Status';

    public function get(){

        $leave_m = load_model( 'leave' );

        if ( is_admin() ) {

            $total    = $leave_m->get_count();
            $pending  = $leave_m->get_count(['status' => 'pending']);
            $approved = $leave_m->get_count(['status' => 'approved']);
            $rejected = $leave_m->get_count(['status' => 'rejected']);

        } else {

            $current_user_id = $_SESSION['current_user']['id'];

            $total = $leave_m->get_count([
                'user_id' => $current_user_id
            ]);
            
            $pending = $leave_m->get_count([
                'status'  => 'pending', 
                'user_id' => $current_user_id 
            ]);

            $approved = $leave_m->get_count([
                'status'  => 'approved', 
                'user_id' => $current_user_id
            ]);

            $rejected = $leave_m->get_count([
                'status'  => 'rejected', 
                'user_id' => $current_user_id
            ]);
        }

        return [
            'total'    => $total,
            'pending'  => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ];
    }

    public function widget(){
        $total = $this->get();

        $base_url = 'leave?selected_status=';
        ?>
        <div id="<?php echo $this->id; ?>" class="collapsible">
            <ul>
                <li>
                    <a href="<?php echo $base_url .'' ;?>">
                        <strong>Total Leave</strong>
                        <span><?php echo $total[ 'total' ]; ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url .'pending';?>">
                    <strong>Total Pending</strong>
                    <span>
                        <?php echo $total[ 'pending' ]; ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url . 'approved';?>">
                    <strong>Total Approved</strong> 
                    <span>
                        <?php echo $total[ 'approved' ]; ?>
                    </span>
                </a>
            </li>
            <li> 
                <a href="<?php echo $base_url . 'rejected';?>">
                    <strong>Total Rejected</strong>
                    <span>
                        <?php echo $total[ 'rejected' ]; ?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <?php
}
}