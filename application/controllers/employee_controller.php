<?php 
class Employee_Controller extends Base_Controller{

    public function index(){

        $data = $this->model->get();
        
        $this->load_view( $data );
    }

    public function employee(){

        $employee = $this->model->get([],
        ['firstName'=>$_POST['firstName'],
        'lastName'=>$_POST['lastName'],
        'email'=>$_POST['email'],
        'phoneNumber'=>$_POST['phoneNumber'],
        'designation'=>$_POST['designation']
        ]
    );

    }
}