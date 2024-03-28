<?php 
abstract class Base_Controller{

    protected $model;

    protected $current_controller;
    
    public function __construct(){
        $child_class = static::class;
        $this->current_controller = explode( '_', strtolower( $child_class ) )[0];
        $this->load_model( $this->current_controller );
    }

    public function load_model( $model = '' ){
        require_once PATH . '/application/models/' . $model . '_model.php';
        $model_class = ucfirst( $model ) . '_Model';

        $this->model = new $model_class();
    }

    public function load_view( $data, $view = '' ){
        extract( $data );
        require PATH . '/application/views/' . $this->current_controller . '_view.php';
    }
}