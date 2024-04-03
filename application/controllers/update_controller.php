
<?php
    class Update_Controller extends Base_Controller{

        public function __construct(){
        parent::__construct();

        }

        public function index(){
            $this->load_view() ;
        }

        public function updateUser(){

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
                $id = $_POST['user_id'];
                $username = $_POST['username'];
                $password = $_POST['password'];

                $users = $model->update($id, $username, $password);
            }
            if(isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $user = $model->query($user_id);
            }
        }
        
        
    }