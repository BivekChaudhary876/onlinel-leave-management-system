
<?php

    class Dashboard_Controller extends Base_Controller{
        protected $post_methods = [ 'save' , 'deleteHoliday' ];

        public function index(){

            if(! isset( $_SESSION[ 'current_user' ] ) ){
                header( "Location: index.php?c=user" );
                exit;
            }

            $holidays = $this->model->get();
            $this->load_view( [
                'page_title' => 'Dashboard', 
                'holidays' => $holidays 
            ],'dashboard' );
        }

        public function save(){
            $holidays_data = [
                'year' => $_POST[ 'year' ],
                'month' => $_POST[ 'month' ],
                'day' => $_POST[ 'day' ],
                'event' => $_POST[ 'event' ]
            ];
            if( isset( $_POST[ 'id'] ) && $_POST[ 'id' ] > 0 ){
                    $holidays_data[ 'id' ] = $_POST[ 'id' ];
            }
            $this->model->save( $holidays_data );
            redirect( 'dashboard' , 'save' );

        }
        public function deleteHoliday() {
            try {
                $holidayId = $_POST[ 'id' ];
                $deleted = $this->model->delete( $holidayId );
                if ( $deleted ) {
                    echo json_encode( [ 'success' => true ] );
                } else {
                    echo json_encode( [ 'success' => false, 'message' => 'Failed to delete holiday' ] );
                }
            } catch (Exception $e) {
                echo json_encode( [ 'success' => false, 'message' => 'Error: ' . $e->getMessage() ] );
            }
        }

        public function logout(){
            parent::logout();
        }
        
    }