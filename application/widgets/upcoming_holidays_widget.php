<?php 

class Upcoming_Holidays_Widget extends Base_Widget{

    protected $name = 'upcoming-holidays';

    protected $icon = 'holiday';

    protected $arrow = 'collapsible';

    protected $id = 'upcoming-holiday';

    protected $title = 'Upcoming Holidays';

    public function widget(){
        $holiday_m = load_model('holiday');
        $holidays = $holiday_m->get_by_upcoming_holidays();
        ?>
        <div id="<?php echo $this->id; ?>" class="collapsible">
            <table>
                <tbody>
                    <?php
                    foreach ( $holidays as $key => $holiday ) :
                     ?>
                     <tr>
                        <td><?php echo ( indexing() + $key + 1 ); ?></td>
                        <td>
                            <a href="holiday/details/<?php echo $holiday[ 'id' ]; ?>">
                             <?php echo ucfirst( $holiday[ 'event' ] ); ?>
                         </a>
                     </td>
                     <td><?php echo $this->format_date( $holiday[ 'from_date' ] ); ?></td>
                 </tr>
                 <?php
             endforeach;
             ?>
         </tbody>
     </table>
 </div>
 <?php
}

}