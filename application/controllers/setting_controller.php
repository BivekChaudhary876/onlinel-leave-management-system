<?php
class Setting_Controller extends Base_Controller{
    public function index(){
        
        $default_page=get_current_page();
        $default_per_page = get_per_page();
        $page = isset($_SESSION['page']) ? intval($_SESSION['page']) : $default_page;
        $per_page = isset($_SESSION['per_page']) ? intval($_SESSION['per_page']) : $default_per_page;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['page'])) {
                $_SESSION['page'] = intval($_GET['page']);
                $page = $_SESSION['page']; 
            }
            if (isset($_GET['per_page'])) {
                $_SESSION['per_page'] = intval($_GET['per_page']);
                $per_page = $_SESSION['per_page']; 
            }
        }

        $this->load_view([
            'page_title' => 'Admin Setting',
            'page' => $page,
            'per_page' => $per_page
        ],'setting');
    }

}


