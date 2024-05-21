<?php 

class Upcoming_Birthday_Widget extends Base_Widget{

    protected $name = 'upcoming-birthday';

    protected $icon = 'birthday';

    protected $arrow = 'collapsible';

    protected $id = 'birth';

    protected $title = 'Upcoming Birthdays';

    public function widget(){
        $user_m = load_model('user');
        $users = $user_m->get_by_upcoming_birthdays();
        ?>
        <div id="<?php echo $this->id; ?>" class="collapsible">
            <table>
                <tbody>
                    <?php
                    foreach( $users as $key => $user ){
                        ?>
                        <tr>
                            <td><?php echo indexing() + $key + 1; ?></td>
                            <td>
                                <a href="user/details/<?php echo $user[ 'id' ]; ?>">
                                    <?php echo ucfirst( $user[ 'username' ] ); ?> 
                                </a>
                            </td>
                            <td><?php echo $this->format_date( $user[ 'birth_date' ] ); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}