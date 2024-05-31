<?php 
class Leave_Controller extends Base_Controller
{
    protected $post_methods = [ 'save', 'delete', 'update_status' ];

    public function index(  )
    {
        $type_m = load_model( 'type' );
        $user_m = load_model( 'user' );
        $users = false;

        $leave_status = [ [ 'status' => 'pending' ], [  'status' => 'approved' ], [  'status' => 'rejected' ] ];

        $where = [];
        $where_count = [];
        if (  isset( $_GET[  'selected_status' ] ) && !empty( $_GET[ 'selected_status' ] ) ) {
            $where[ 'lr.status' ] = $_GET[ 'selected_status' ];
            $where_count[ 'status' ] = $_GET[ 'selected_status' ];
        }

        if ( isset( $_GET[ 'selected_user' ] ) && $_GET[ 'selected_user' ] !== '0' ) {
            $where[ 'lr.user_id' ] = $_GET[ 'selected_user' ];
            $where_count[ 'user_id' ] = $_GET[ 'selected_user' ];
        }

        if ( isset( $_GET[ 'from_date' ] ) && $_GET[ 'from_date' ] ) {
            $where[ 'DATE( lr.created_date ) >=' ] = $_GET[ 'from_date' ];
            $where_count[ 'DATE( created_date ) >=' ] = $_GET[ 'from_date' ];
        }

        if ( isset( $_GET[ 'to_date' ] ) && $_GET[ 'to_date' ] ) {
            $where[ 'DATE( lr.created_date ) <=' ] = $_GET[ 'to_date' ];
            $where_count[ 'DATE( created_date ) <=' ] = $_GET[ 'to_date' ];
        }

        if ( is_admin() ) {
            $users = $user_m->get( [  ], false );
            $total = $this->model->get_count( $where_count );
        } else {
            $where[ 'lr.user_id' ] = get_current_user_id(  );
            $where_count[ 'user_id' ] = get_current_user_id(  );
            $total = $this->model->get_count( $where_count );
            $users = $user_m->get( [ "id" => get_current_user_id(  ) ], false );
        }

        // Check if export button is clicked
        if ( isset( $_GET[ 'export' ] ) ) {
            if ((isset($_GET['selected_user']) && $_GET['selected_user'] !== '0')) {
                $where['lr.status'] = 'approved';
                $leaves = $this->model->get($where );

                // Calculate total leave days in a year and overall leave days per user
                $leave_days_by_user = $this->calculateTotalLeaveDays( $leaves );
                $overall_leave_days = $this->calculateOverallLeaveDays( $leave_days_by_user );

                // Create HTML content for Excel file
                $html = '<table border="1"><tr><th>Name</th><th>Type</th><th>Status</th><th>From Date</th><th>To Date</th><th>Total Leave Days</th><th>Description</th></tr>';
                foreach ( $leaves as $leave ) {
                    $html .= '<tr>';
                    if ( is_admin() ) {
                        $html .= '<td>' . $leave[ 'username' ] . '</td>';
                    }
                    $html .= '<td>' . $leave[ 'leave_type' ] . '</td>';
                    $html .= '<td>' . $leave[ 'status' ] . '</td>';
                    $html .= '<td>' . $leave[ 'from_date' ] . '</td>';
                    $html .= '<td>' . $leave[ 'to_date' ] . '</td>';

                    // Calculate total leave days for this leave entry
                    $from_date = new DateTime( $leave[ 'from_date' ] );
                    $to_date = new DateTime( $leave[ 'to_date' ] );
                $leave_days = $from_date->diff( $to_date )->days + 1; // Including both start and end dates

                $html .= '<td>' . $leave_days . '</td>';
                $html .= '<td>' . $leave[ 'description' ] . '</td>';
                $html .= '</tr>';
            }

            // Add single row for overall leave days per year
            foreach ( $overall_leave_days as $year => $leave_days ) {
                $html .= '<tr><td colspan="5"><strong>Overall Leave Days ( ' . $year . ' )</strong></td><td><strong>' . implode( '</strong></td><td><strong>', $leave_days ) . '</strong></td></tr>';
            }

            $html .= '</table>';

            // Set headers for download
            header( 'Content-Type: application/xls' );
            header( 'Content-Disposition: attachment;filename="leave_report.xls"' );
            echo $html;
            exit; // Stop further execution
        }else {
            echo '<script>alert("Please select a user.");</script>';
        }
    }

    $leaves = $this->model->get( $where );
    $leave_types = $type_m->get( [], false );

    $this->load_view( [ 
        'users'        => $users,
        'page_title'   => 'Leave List',
        'leave_types'  => $leave_types,
        'leaves'       => $leaves,
        'leave_status' => $leave_status,
        'total'        => $total,
        'modal'        => [ 
            "title"    => "Add / Update Leave",
            "view"     => "leave"
        ]
    ], 'leave' );
}

public function details( $id )
{
    if ( !$id ) {
        redirect( 'leave' );
    }

    $details = $this->model->get( [ 'lr.id' => $id ], true );

    if ( !$details ) {
        redirect( 'leave' );
    }

    $this->load_view( [ 
        'page_title' => 'Leave Details',
        'details'    => $details,
    ], 'leave_details' );
}

public function save()
{
    $user_id = isset( $_POST[ 'user_id' ] ) && $_POST[ 'user_id' ] !== '' ? $_POST[ 'user_id' ] : get_current_user_id(  );
    $data = [ 
        'user_id'     => $user_id,
        'type_id'     => $_POST[ 'type_id' ],
        'from_date'   => $_POST[ 'from_date' ],
        'to_date'     => $_POST[ 'to_date' ],
        'description' => $_POST[ 'description' ],
    ];

    if ( isset( $_POST[ 'id' ] ) && $_POST[ 'id' ] > 0 ) {
        $data[ 'id' ] = $_POST[ 'id' ];
    }

    $this->model->save( $data );
    redirect( 'leave' );
}

public function delete()
{
    try {
        $leaveId = $_POST[ 'id' ];
        $deleted = $this->model->delete( $leaveId );
        if ( $deleted ) {
            echo json_encode( [ 'success' => true ] );
        } else {
            echo json_encode( [ 'success' => false, 'message' => 'Failed to delete leave' ] );
        }
    } catch ( Exception $e ) {
        echo json_encode( [ 'success' => false, 'message' => 'Error: ' . $e->getMessage(  ) ] );
    }
}

public function update_status()
{
    try {
        $leaveId = $_POST[ 'id' ];
        $status = $_POST[ 'status' ];

            // Update the status in the database
        $this->model->save( [ 'id' => $leaveId, 'status' => $status ] );

        echo json_encode( [ 'success' => true ] );
    } catch ( Exception $e ) {
        echo json_encode( [ 'success' => false, 'message' => 'Error: ' . $e->getMessage(  ) ] );
    }
}

public function calculateTotalLeaveDays( $leaves )
{
    $leave_days_by_user = [];

    foreach ( $leaves as $leave ) {
        $user_id = $leave[ 'user_id' ];
        $from_date = new DateTime( $leave[ 'from_date' ] );
        $to_date = new DateTime( $leave[ 'to_date' ] );

            // Iterate through each year between from_date and to_date
        for ( $date = clone $from_date; $date <= $to_date; $date->modify( '+1 year' ) ) {
            $year = $date->format( 'Y' );

                // Calculate overlapping period
            $year_start = new DateTime( "$year-01-01" );
            $year_end = new DateTime( "$year-12-31" );
            $leave_start = $from_date > $year_start ? $from_date : $year_start;
            $leave_end = $to_date < $year_end ? $to_date : $year_end;

            $leave_days = 0;
            if ( $leave_start <= $leave_end ) {
                    $leave_days = $leave_start->diff( $leave_end )->days + 1; // Including both start and end dates
                }

                // Aggregate leave days per user per year
                if ( !isset( $leave_days_by_user[ $user_id ] ) ) {
                    $leave_days_by_user[ $user_id ] = [  ];
                }
                if ( !isset( $leave_days_by_user[ $user_id ][ $year ] ) ) {
                    $leave_days_by_user[ $user_id ][ $year ] = 0;
                }
                $leave_days_by_user[ $user_id ][ $year ] += $leave_days;
            }
        }

        return $leave_days_by_user;
    }

    public function calculateOverallLeaveDays( $leave_days_by_user )
    {
        $overall_leave_days = [];

        foreach ( $leave_days_by_user as $user_id => $years ) {
            foreach ( $years as $year => $total_leave_days ) {
                if ( !isset( $overall_leave_days[ $year ] ) ) {
                    $overall_leave_days[ $year ] = [];
                }
                $overall_leave_days[ $year ][] = $total_leave_days;
            }
        }

        return $overall_leave_days;
    }
}
