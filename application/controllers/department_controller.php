<?php 
class Department_Controller extends Base_Controller{


	// protected $post_methods = [ 'save' , 'delete' ];

	public function __construct(){
		if( !is_admin() ){
			redirect( "dashboard" );
		}

		parent::__construct();
	}

	public function index(){
		$departments = $this->model->get();
		$total = $this->model->get_count();

		$this->load_view( [
			'page_title' => 'Department',
			'departments' => $departments,
			'total' => $total,
			'modal' => [
				"title" => "Add / Update Department",
				"view" => 'department_category' 
			],
		], 'department' );
	}

	public function details( $id ){
		if ( !$id ) {
			redirect('department');
		}

		$details = $this->model->get(
			[ 'id' => $id ], 
			true
		);

		if (!$details) {
			redirect('department');
		}

		$this->load_view([
			'page_title'    => 'Department Details',
			'details' => $details,
		], 'department_details');  
	}

	public function save(){
		$valid_data = [ 'id', 'name'];
		$data = [];
		foreach( $valid_data as $d ){
			if( isset( $_POST[ $d ] ) ){
				$data[ $d ] = $_POST[ $d ];
			}
		}

		if( isset( $_POST[ 'id' ] )  && $_POST[ 'id' ] > 0 ){
			$data[ 'id' ] = $_POST[ 'id' ];
			$this->model->save( $data );
		}else{
			unset( $data[ 'id' ] );
			$this->model->save( $data );
		}
		redirect( 'department');
	}

	public function delete(){
		try{ 
			$id = $_POST[ 'id' ];
			$deleted = $this->model->delete( $id );
			if( $deleted ){
				echo json_encode( [ 'success' => true ] );
			}else{
				echo json_encode( [ 'sucess' => false, 'message' => 'Failed to delete deparment' ] );
			}
		}catch( Exception $e ){
			echo json_encode( [ 'success' => false, 'message' => 'Error' . $e.getMessage() ] );
		} 
	}
}