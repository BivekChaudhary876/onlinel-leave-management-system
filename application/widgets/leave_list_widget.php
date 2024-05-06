<?php 

class Leave_List_Widget extends Base_Widget{

    protected $name = 'leave-list';

    protected $title = 'Recent Leave Requests By Employee';

    public function widget(){
 
        $leave_m = load_model( 'leave' );
        $total_leave_requests = $leave_m->get( [], false );
        ?>
        <table class="table">
            <tbody>
                <?php 
                $count =0;
                foreach( $total_leave_requests as $key => $leave ) : 
                    if( $count >= 5):
                        break;
                    endif;?>
                    <tr> 
                        <td><?php  echo ( indexing() + $key+1 ) ; ?></td>
                        <?php if( is_admin() ): ?>
                                <td><?php echo $leave[ 'username' ]; ?></td>
                        <?php endif; ?>
                        <td class="status"><?php echo get_status_badge( $leave[ 'status' ] ) ?></td>
                        <td>
                            <a href='leave/details/<?php echo $leave[ 'id' ]; ?>'"><span class="btn text-secondary">View </span></a>
                        </td>
                    </tr>
                <?php 
                $count++;
                endforeach; ?>
            </tbody>
        </table>
        <?php
    }
}