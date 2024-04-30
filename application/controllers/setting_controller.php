<?php
class Setting_Controller extends Base_Controller{
    public function index(){
        $settings = $this->model->get();
        $data = [];
        foreach( $settings as $setting ){
            $data[ $setting[ 'name' ] ] = $setting[ 'value' ];
        }

        $this->load_view( [ 
            'page_title' => 'Settings',
            'settings'   => $data
        ], 'setting' );
    }

    public function save() {
       
        $data = [
            [ "data" => intval( $_POST[ 'per_page' ] ), "where" => "per_page" ],
            [ "data" => $_POST[ 'logo' ], "where" => "logo" ],
            [ "data" => $_POST[ 'header' ], "where" => "header" ],
            [ "data" => $_POST[ 'primary' ], "where" => "primary" ]
        ];

        foreach( $data as $d ){
            $this->model->save( [ "value" => $d[ "data" ] ], [ 'name' => $d[ "where" ] ] );
        }

        redirect( 'setting');
    }
}



