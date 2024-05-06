<?php
abstract class Base_Widget{

    protected $name = '';

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
            <h5><?php echo $this->title; ?></h5>
            <div>
                <?php echo $this->widget(); ?>
            </div>
        </div>
        <?php
    }
}