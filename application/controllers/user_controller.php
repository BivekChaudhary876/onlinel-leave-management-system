<?php 

class User_Controller extends Base_Controller{

    protected $post_methods = [ 'login', 'save', 'getUser', 'updateUser', 'deleteUser' ];

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->load_view( [], 'login' );
    }

    // method post
    public function login(){

        if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $where = [ 
                'username' => $username, 
                'password' => $password
            ];

            $user = $this->model->get( $where );
            if( empty( $user ) ){
                redirect( 'user' );
            } else {
                //user exists
                $_SESSION[ 'current_user' ] = $user[ 0 ];
                redirect( 'dashboard' );
            }
        }  

        $this->index();
    }

    public function list(){
        $users = $this->model->get();
        $this->load_view( [ 
            'page_title' => 'User List',
            'users' => $users 
        ], 'user_lists' );
    }
    
    public function save(){

        $data = [
            'username' => $_POST[ 'username' ], 
            'email'    => $_POST[ 'email' ], 
            'password' => $_POST[ 'password' ]
        ];

        if( isset( $_POST[ 'id' ] ) && $_POST[ 'id' ] > 0 ){ //update
            $data[ 'id' ] = $_POST[ 'id' ];
        }

        $this->model->save( $data );

        redirect( 'user' , 'list');
       
    }

    // Method to handle deleting a user
    public function deleteUser() {
        try {
            $userId = $_POST['userId'];
            $deleted = $this->model->delete($userId);
            if ($deleted) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function holidays() {
        if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {
            if( isset( $_POST[ 'year' ] ) && isset( $_POST[ 'month' ] ) ) {
                $year = intval( $_POST[ 'year' ] );
                $month = intval( $_POST[ 'month' ]);
            } else {
                // If year parameter is not provided, use the current year
                $year = date( 'Y' );
                $month = date( 'n' );
            }
            // Calendarific API endpoint
            $api_endpoint = 'https://calendarific.com/api/v2/holidays';
            // Your API key
            $api_key = 'RKYemXu8aIWeXr9fQFPBzczXIzKLpMh7';

            // Parameters for the API request
            $params = array(
                'api_key' => $api_key,
                'country' => 'NP', // Country code for the United States
                'year' => $year,
                'month'=> $month, // Year for which you want to fetch holidays
                'type' => 'national' // Type of holidays (national, local, religious, etc.)
            );

            // Build query string
            $query_string = http_build_query( $params );

            // Final URL
            $url = $api_endpoint . '?' . $query_string;

            // Initialize cURL session
            $ch = curl_init();

            // Set cURL options
            curl_setopt_array( $ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
            ));

            // Execute the request and get the response
            $response = curl_exec( $ch );

            // Check for errors
            if ( $response === false ) {
                echo 'Error fetching data: ' . curl_error( $ch );
                exit;
            }

            // Close cURL session
            curl_close( $ch );

            // Decode JSON response
            $data = json_decode( $response, true );

            // Check if data retrieval was successful
            if ( isset( $data[ 'response' ][ 'holidays' ] ) ) {
                // Display holidays
                echo '<h2>Holidays for ' . $year .'</h2>';
                echo '<ul>';
                foreach ( $data[ 'response' ][ 'holidays' ] as $holiday ) {
                    echo '<li>' . $holiday[ 'name' ] . ': ' . $holiday[ 'date' ][ 'iso' ] . '</li>';
                }
                echo '</ul>';
            } else {
                echo 'No holidays found for ' . $year . '.';
            }
        } else {
            echo "Invalid request method!";
        }
    }






}