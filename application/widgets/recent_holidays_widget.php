<?php 

class Recent_Holidays_Widget extends Base_Widget{

    protected $name = 'recent-holidays';

    protected $title = 'Recent Holidays';

    public function widget(){
        $holiday_m = load_model('holiday');
        $holidays = $holiday_m->get();
        usort($holidays, function($a, $b) {
            return strtotime($a['from_date']) - strtotime($b['from_date']);
        });
        $upcoming_holidays = [];
        $today = date( 'Y-m-d' );
        $tomorrow = date( 'Y-m-d', strtotime( '+1 day' ) );

        foreach ( $holidays as $key => $holiday ) :
            $holiday_date = date( 'Y-m-d', strtotime( $holiday[ 'from_date' ] ) );

            if ( $holiday_date === $today ) :
                $upcoming_holidays[ 'today' ][] = $holiday;
            elseif ( $holiday_date === $tomorrow ) :
                $upcoming_holidays[ 'tomorrow' ][] = $holiday;
            else:
                $upcoming_holidays[ $holiday_date ][] = $holiday;
            endif;
        endforeach;
        ?>
        <table class="table">
            <tbody>
                <?php
                $count=0;
                foreach($upcoming_holidays as $day => $holidays ):
                    foreach( $holidays as $holiday ):
                        if ( $count >= 5 ) :
                            break;
                        endif;
                        ?>
                        <tr>
                            <td><?php echo ( indexing() + ( $count + 1 ) ); ?></td>
                            <td><?php echo $holiday[ 'event' ]?> 
                            <td><strong><?php echo ( isset( $day ) ? ( $day == 'today' ? 'Today' : ( $day == 'tomorrow' ? 'Tomorrow' : date( 'jS M, l', strtotime( $day ) ) ) ) : ''); ?></strong></td>
                            <td><a href="holiday/details/<?= $holiday[ 'id' ] ?>"><?php echo icon('view');?></a></td>
                        </tr>
                        <?php 
                        $count++;
                    endforeach;
                endforeach;
                ?>
            </tbody>
        </table>
        <?php
    }
}