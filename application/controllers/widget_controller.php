<?php

class Widget_Controller extends Base_Controller{

    protected $post_methods = [ 'toggle_widget' ];

    public function __construct(){
        parent::__construct();
        $this->model = load_model( 'setting' );
    }

    public function index(){

        $widget_status = [
            ['status'=>'all'],
            ['status'=>'active'],
            ['status'=>'inactive']
        ];
        
        $selected_status = isset($_GET['selected_status']) ? $_GET['selected_status'] : 'all';
        $where = [];
        if ($selected_status === 'active') {
            $where['status'] = 'active';
        } elseif ($selected_status === 'inactive') {
            $where['status'] = 'inactive';
        }
        $db_widgets = get_active_widgets($where);

        if ($selected_status === 'all') {
            $db_widgets = get_active_widgets();
        }

        // Get installed widgets and render the view
        $active_widgets = $this->list_widgets($db_widgets);

        $this->load_view([
            'page_title'        => 'Widget',
            'installed_widgets' => $this->get_installed_widgets(),
            'active_widgets'    => $active_widgets,
            'widget_status'     => $widget_status,
            'selected_status'   => $selected_status,
        ], 'widget');
    }

    public function list_widgets( $db_widgets ){
        $active_widgets = [];
        foreach( $db_widgets as $db_widget ){
            foreach( $db_widget as $widget ){
                $active_widgets[] = str_replace( '-', ' ', $widget );
            }
        }

        return $active_widgets;
    }

    public function toggle_widget(){
        $name = $_POST[ 'name' ];
        $db_widgets = get_active_widgets();
        $active_widgets = $this->list_widgets( $db_widgets );

        http_response_code(200);
        header('Content-type: application/json');

        if( in_array( $name, $active_widgets ) ){
            $this->deactivate( $name );
            $data = [ "operation" => "deactivate" ];
        }else{
            $this->activate( $name );
            $data = [ "operation" => "activate" ];
        }
        echo json_encode( $data );
        die;
    }

    public function activate( $name ){
        $active_widgets = get_active_widgets();
        $active_widgets[ 'first' ][] = str_replace( ' ', '-', $name );
        $this->model->save( [ "value" => serialize( $active_widgets ) ], [ "name" => "widget_order" ] );
    }

    public function deactivate( $name ){

        $active_widgets = get_active_widgets();
        
        $new_active_widgets = [
            "first"  => [],
            "second" => [],
            "third"  => []
        ];

        foreach ( $active_widgets as $section => $widgets ) {
            $index = array_search(str_replace( ' ', '-', $name ), $widgets );
            if ( $index !== false ) {
                unset( $widgets[$index] );
                $new_active_widgets[$section] = array_values( $widgets );
            }else{
                $new_active_widgets[$section] = $widgets;
            }
        }

        $this->model->save(["value" => serialize($new_active_widgets)], ["name" => "widget_order"]);
    }

    public function get_installed_widgets(){
        $widgets = glob(PATH . '/application/widgets/*.php');
        $installed_widgets = []; 
        foreach( $widgets as $widget ){
            $a = explode( '/', $widget );
            $a = end($a);
            $name = str_replace( '_widget.php','', $a );
            $installed_widgets[] = str_replace( '_', ' ',  $name ); 
        }

        return $installed_widgets;
    }
}