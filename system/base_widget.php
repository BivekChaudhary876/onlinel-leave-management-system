<?php
abstract class Base_Widget{

    protected $name = '';

    protected $icon = '';

    protected $id = '';

    protected $title = '';

    protected static $widgets = [];

    public $position = 'first';

    public function __construct(){
        $setting_m    = load_model( 'setting' );
        $widget_order = $setting_m->get( [ "name"=> "widget_order" ] );
        $widget_order = unserialize( $widget_order[0][ 'value' ] );
        
        foreach( $widget_order as $col => $widgets ){
            foreach ( $widgets as $widget ){
                if( $this->name == $widget ){
                    $this->position = $col;
                }
            }
        }
    }

    public function render(){
        ?>
        <div id="<?php echo str_replace ( ' ', '-', $this->name ); ?>" class="draggable-widget <?php echo $this->name; ?>">
            <h5 onclick="toggleContent('<?php echo $this->id; ?>')"><?php echo icon($this->icon) . $this->title; ?></h5>
            <div class="widget"> 
                <?php echo $this->widget(); ?>
            </div>
        </div>
        <?php
    }

    public function format_date( $date ){

        $today = date('m-d');
        $tomorrow = date('m-d', strtotime('+1 day'));

        $current_date = date( 'm-d', strtotime( $date ) );
        $date = date( 'jS M, l', strtotime( $date ) );

        if( $current_date === $today ) {
            return '<span class="today">Today</span>';
        } elseif( $current_date === $tomorrow ){
            return '<span class="tommorrow">Tommorrow</span>';
        } 

        return "<span class='date'>{$date}</span>";
    }
}