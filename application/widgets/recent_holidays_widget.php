<?php 

class Recent_Holidays_Widget extends Base_Widget{

    protected $name = 'recent-holidays';

    protected $icon = 'holiday';

    protected $title = 'Recent Holidays';

    public function widget(){
        $holiday_m = load_model('holiday');
        $holidays = $holiday_m->get_by_upcoming_holidays();
        ?>
        <table>
            <tbody>
                <?php
                foreach ( $holidays as $key => $holiday ) { ?>
                    <tr>
                        <td><?php echo ( indexing() + $key + 1 ); ?></td>
                        <td><?php echo ucfirst( $holiday[ 'event' ] ); ?></td>
                        <td><?php echo $this->format_date( $holiday[ 'from_date' ] ); ?></td>
                        <td><a href="holiday/details/<?= $holiday[ 'id' ] ?>"><?php echo icon('view'); ?></a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }

}