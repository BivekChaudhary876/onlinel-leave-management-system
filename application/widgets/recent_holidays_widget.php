<?php 

class Recent_Holidays_Widget extends Base_Widget{

    protected $name = 'recent-holidays';

    protected $title = 'Recent Holidays';

    public function widget(){
        $holiday_m = load_model('holiday');
        $holidays = $holiday_m->get([], false);
        ?>
        <table class="table">
        <tbody>
        <?php
        $count=0;
        foreach($holidays as $key => $holiday):
            if($count>=5):
                break;
            endif;
        ?>
        <tr>
            <td><?php echo ( indexing() + $key+1 );?></td>
            <td><?php echo $holiday[ 'event' ] ?></td>
            <td>
                <a href='holiday/details/<?php echo $holiday[ 'id' ]; ?>'"><span class="btn text-secondary">View </span></a>
            </td>
        </tr>
        <?php endforeach;
        $count++;?>
        </tbody>
        </table>
        <?php
    }
}