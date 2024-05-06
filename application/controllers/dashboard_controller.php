<?php
class Dashboard_Controller extends Base_Controller {

    protected $post_methods = [ 'save_widget_order' ];

    public function index() {
        $this->load_view([
            'page_title' => 'Leave List'
        ], 'dashboard');
    }
    
    public function save_widget_order(){
        $setting_m = load_model( 'setting' );
        $widget_order = serialize( $_POST[ 'widget_order' ] );
        $setting_m->save( [ "value" => $widget_order ], [ 'name' => 'widget_order' ] );
    }

    public function logout() {
        parent::logout();
    }
}
