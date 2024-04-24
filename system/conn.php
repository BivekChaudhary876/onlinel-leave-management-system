<?php
require_once 'config.php';

class Conn{

    protected $last_query = "";

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

    public function select( $cols, $table ){
        
        $this->last_query = "SELECT ";
        
        if( !empty( $cols )){
            $this->last_query .= implode( ',', $cols );
        }else{
            $this->last_query .= '*';
        }

        $this->last_query .= " FROM {$table}";
    }

    public function where( $conditions = [] ){
        if( !empty( $conditions ) ){
            $this->last_query .= ' WHERE ';
            foreach( $conditions as $key => $value ){
                $this->last_query .= "$key= '" .  $value ."' AND ";
            }

            $this->last_query = rtrim( $this->last_query, 'AND ');

        }
    }

    public function join( $table, $condition, $type = 'INNER JOIN' ){
        $this->last_query .= " {$type} {$table} ON {$condition}";
    }

    public function paginate(){
        $this->last_query = get_paginated_sql( $this->last_query );
    }

    public function get_last_query(){
        return $this->last_query;
    }

    public function order_by( $col = 'id', $order = 'DESC' ){
        $this->last_query .= " ORDER BY {$col} {$order}";
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

    public function exec( $sql = false ) {
        if( $sql ){
            $this->last_query = $sql;
        }
        $result = mysqli_query( $this->connection, $this->last_query );
        return $result;
    }

    public function get_num( $result_set ){
        return mysqli_num_rows( $result_set );
    }

    public function get_rows( $query ){
        $result =$this->exec( $query );
        
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

