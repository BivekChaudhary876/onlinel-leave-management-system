<?php 

class Upcoming_Birthday_Widget extends Base_Widget{

    protected $name = 'upcoming-birthday';

    protected $title = 'Upcoming birthday';

    public function widget(){
        $user_m = load_model('user');
        $users = $user_m->get();

        usort($users, function( $a, $b ) {
            return strtotime( $a[ 'birth_date' ] )-strtotime( $b[ 'birth_date' ] );
        });

        $upcoming_birthdays = [];
        $today = date( 'j' );
        $tomorrow = date( 'j', strtotime( '+1 day' ) );

        foreach ( $users as $key => $user ) :
            $birthday_date = date( 'Y-m-d', strtotime( $user[ 'birth_date' ] ) );

            if ( $birthday_date === $today ) :
                $upcoming_birthdays[ 'today' ][] = $user;
            elseif ( $birthday_date === $tomorrow ) :
                $upcoming_birthdays[ 'tomorrow' ][] = $user;
            else:
                $upcoming_birthdays[ $birthday_date ][] = $user;
            endif;
        endforeach;

        ?>
        <table class="table">
            <tbody>
                <?php
                $count = 0;
                foreach ( $upcoming_birthdays as $day => $users ) :
                    foreach ( $users as $user ) :
                        if ( $count >= 5 ) :
                            break;
                        endif;
                        ?>
                        <tr>
                            <td><?php echo ( indexing() + ( $count + 1 ) ); ?></td>
                            <td><?php echo $user[ 'username' ] . "'s Birthday"; ?> 
                            <td><strong><?php echo ( isset( $day ) ? ( $day == 'today' ? 'Today' : ( $day == 'tomorrow' ? 'Tomorrow' : date( 'jS M, l', strtotime( $day ) ) ) ) : ''); ?></strong></td>
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
