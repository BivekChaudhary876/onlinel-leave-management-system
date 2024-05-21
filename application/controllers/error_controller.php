<?php
class Error_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load_view([], '404');
    }

    public function method_not_found() {
        $this->load_view([], '405');
    }
}