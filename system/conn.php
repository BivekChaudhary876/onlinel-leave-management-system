<?php
require_once 'config.php';

class Conn{

    protected static $instance = null;
    protected $connection;

    public static function get_instance(){
        if( ! self::$instance ){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct(){
       $this->connection =  mysqli_connect( DB_HOST, DB_USER, DB_PASS );
        if( ! $this->connection ){
            die( "Database connection failed: " . mysqli_connect_error() );
        }
        $db_selected = mysqli_select_db( $this->connection, DB_NAME );
        if ( !$db_selected ) {
            die( "Database selection failed: " . mysqli_error( $this->connection ) );
        }

    }

    public function query( $query ){
        return mysqli_query( $this->connection, $query );
    }

    public function fetch( $result_set ){
        $data = [];
        while( $row = mysqli_fetch_array( $result_set, MYSQLI_ASSOC ) ){
            $data[] = $row;
        };

        mysqli_free_result( $result_set );

        return $data;
    }

    public function fetch_row( $result_set ){
        $data = mysqli_fetch_row( $result_set );
        mysqli_free_result( $result_set );

        return $data[0];
    }

    public function escape( $string ){
        return $string;
    }

    // public function executeBuilder( $sql, $params = [] ) {
    //     $statement = $this->connection->prepare( $sql );
        
    //     if ($params) {
    //         $types = str_repeat( 's', count( $params ) ); 
    //         $statement->bind_param( $types, ...$params );
    //     }

    //     $statement->execute();
    //     return $statement->get_result();
    // }

    public function executeBuilder($sql, $params = []) {
        $statement = $this->connection->prepare($sql);
        if ($params) {
            $param_types = str_repeat('s', count($params));
            $statement->bind_param($param_types, ...$params);
        }
        $statement->execute();
        return $statement->get_result();
    }



    public function get_num( $result_set ){
        return mysqli_num_rows( $result_set );
    }

    public function get_rows( $query ){
        $result = mysqli_query( $this->connection, $query );
        
        if ( !$result ) {
            die("Query failed: " . mysqli_error(  $this->connection));
        }

        $num_rows = mysqli_num_rows(  $result );

        mysqli_free_result(  $result );

        return $num_rows;
    }

    public function close(){
        mysqli_close( $this->connection );
    }
}

