<?php 
$role = $_SESSION['current_user']['role']; 
$leave_id=1;
$i = 1;
$j = 1;
$l = 1;
$r = 1;

?>
  
<div class="my-3">
    <?php if($role == 'admin'): ?>
        <div class="my-3 text-center">
            <h1>Check Leave Requests</h1>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="my-3 text-center d-flex justify-content-evenly">
                    <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves </br><?= $totalLeaveCount ?></button>
                    <button id="pendingBtn" class="btn btn-outline-warning">Pending </br> <?= $pendingLeaveCount ?></button>
                    <button id="approvedBtn" class="btn btn-outline-success">Approved </br> <?= $approvedLeaveCount ?></button>
                    <button id="rejectedBtn" class="btn btn-outline-danger">Rejected </br> <?= $rejectedLeaveCount ?></button>
                    
                </div>
            </div>
            <div class="col-3">
                <div class="my-3 text-end">
                    <!-- Form to select username -->
                    <form method="post">
                        <select name="selected_user" id="usernameDropdown" class="p-1 btn border-success rounded-start rounded-end">
                            <option value="0"><?php echo 'Select User' ?></option>
                            <?php foreach($usernames as $user): ?>
                                <option value="<?= $user ?>"><?= $user ?></option>
                                <?php endforeach; ?>
                            </select>
                        <input type="submit" value="Filter" class="p-1 btn btn-outline-success">
                    </form>
                </div>
                <!-- Add a dropdown menu to select the month -->
                <div class="my-3 text-end">
                    <form method="post" id="selectedMonth" >
                        <select name="selected_month" id="monthDropdown" class="p-1 btn border-primary rounded-start rounded-end">
                            <option value="0">Select Month</option>
                            <?php 
                        // Generate options for the last 12 months
                        for ($x = 0; $x >= -11; $x--) {
                            $month = date('F Y', strtotime("$x months"));
                            echo "<option value='$month'>$month</option>";
                        }
                        ?>
                        </select>
                        <input type="submit" value="Filter" id="submitBtn" class="p-1 btn btn-outline-primary"  onclick="showTable()">
                    </form>
                </div>
        </div>
        </div>

        <!-- Display leave requests for the selected user -->
        <?php if(isset($selectedUserLeaveRequests) && !empty($selectedUserLeaveRequests)): ?>
            <div class="my-3 text-center">
                    <h2>Leave Requests for <?= $selected_user ?></h2>
                    <h3>Total Leave Days : <?= $totalLeaveDays ?></h3>
            </div>
            <div class="my-3 text-center d-flex justify-content-evenly">
                <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br><?= $totalLeaveCount ?></button>
                <button id="pendingBtn" class="btn btn-outline-warning">Pending<br><?= $pendingLeaveCount ?></button>
                <button id="approvedBtn" class="btn btn-outline-success">Approved<br><?= $approvedLeaveCount ?></button>
                <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br><?= $rejectedLeaveCount ?></button>
            </div>
        <?php endif; ?>

    <?php elseif($role == 'user'): ?>
        <div class="text-center my-3">
            <h2>Leave Requests</h2>
            <h3>Total Leave Days : <?= $totalLeaveDays ?></h3>
        </div>
        <div class="my-3 text-center d-flex justify-content-evenly">
            <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br><?= $totalLeaveCount ?></button>
            <button id="pendingBtn" class="btn btn-outline-warning">Pending<br><?= $pendingLeaveCount ?></button>
            <button id="approvedBtn" class="btn btn-outline-success">Approved<br><?= $approvedLeaveCount ?></button>
            <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br><?= $rejectedLeaveCount ?></button>
        </div>
    <?php endif; ?>
</div>

<!-- Leave table -->
<?php if( $display_normal_table ): ?>
<div id="normalTableContainer" class="my-3">
    <table id="normalTable" class="table table-striped table-light">
    <thead>
        <tr class="table-success text-center">
            <th scope="col">Leave ID</th>
            <?php if( $role == 'admin'){?>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Department</th>
            <?php }?>
            <th scope="col">Type</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <?php foreach( $leave_requests as $leave_request ):
                if ( $role == 'admin' || ($role =='user' && $leave_request[ 'status' ] == 1 )) : ?>
              <th scope="col">Actions</th>
              <?php break; endif; ?>
                <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>

        <?php foreach( $leave_requests as $leave_request ):
          // Trim whitespace and convert to lowercase for comparison
            $leave_username = strtolower(trim($leave_request['username']));
            $session_username = strtolower(trim($_SESSION['current_user']['username']));
            // Trim whitespace and convert to lowercase for comparison
            $leave_email = strtolower(trim($leave_request['email']));
            $session_email = strtolower(trim($_SESSION['current_user']['email']));?>
          <?php if ($role == 'admin' || ($role == 'user' && $leave_username == $session_username && $leave_email == $session_email)) : ?>
        <tr class="text-center"> 
            <td><?php  echo $leave_id++ ?></td>
            <?php if( $role =='admin' ):?>
            <td><?= $leave_request[ 'username' ];?></td>
            <td><?= $leave_request[ 'email' ];?></td>
            <td><?= $leave_request[ 'department' ];?></td>
        <?php endif; ?>
            <td><?php  echo $leave_request[ 'type' ]; ?></td>
            <td><?php  echo $leave_request[ 'startDate' ]; ?></td>
            <td><?php  echo $leave_request[ 'endDate' ]; ?></td>
            <td><?php  echo $leave_request[ 'description' ]; ?></td>
            <td id="<?php echo $leave_request['id']; ?>"> <!-- Add an ID for the status cell -->
          <?php 
            // Check if 'status' key exists in $leave_request
            if(isset($leave_request[ 'status' ] )) {
              // 'status' key exists, so echo its value
              if( $leave_request['status'] == 1 ) {
                echo '<span class="badge text-bg-warning">Pending</span>';
              } elseif ( $leave_request[ 'status' ] == 2 ) {
                echo '<span class="badge text-bg-success">Approved</span>';
              } elseif ( $leave_request[ 'status' ] == 3 ) {
                echo '<span class="badge text-bg-danger">Rejected</span>';
              }
            } else {
              // 'status' key doesn't exist in $leave_request
              echo "Status not available";
            }
          ?>
        </td>
         <?php if( $role =='admin'): ?>
              <td class="text-center">
                <button type="button" class="btn btn-outline-success approveLeave" data-id="<?= $leave_request[ 'id' ] ?>">Approve</button>
                <button type="button" class="btn btn-outline-danger rejectLeave" data-id="<?= $leave_request[ 'id' ] ?>">Reject</button>
              </td>
              <?php else: ?>

                <?php if( $leave_request['status']== 1 ): ?>
              <td class="text-center">
                <button type="button" class="btn btn-outline-danger deleteLeave" data-id="<?= $leave_request[ 'id' ] ?>">Delete</button>
              </td>
              <?php endif; ?>
              <?php endif; ?>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- Selected Month Leave table -->
<?php else:?>
<div id="selectedTableContainer" class="my-3 hidden">
    <table id="selectedTable" class="table table-striped table-light hidden" >
        <thead>
            <tr class="table-success text-center">
                <th scope="col">Leave ID</th>
                <?php if ($role == 'admin') : ?>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Department</th>
                <?php endif; ?>
                <th scope="col">Type</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <?php 
                // Sort leave requests by end date in descending order
                usort($filtered_leave_requests, function($a, $b) {
                    return strtotime($b['endDate']) - strtotime($a['endDate']);
                });
                foreach ($filtered_leave_requests as $leave_request) :
                    if ($role == 'admin' || ($role == 'user' && $leave_request['status'] == 1)) : ?>
                        <th scope="col">Actions</th>
                        <?php break;
                    endif;
                endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filtered_leave_requests as $leave_request) :
                // Trim whitespace and convert to lowercase for comparison
                $leave_username = strtolower(trim($leave_request['username']));
                $session_username = strtolower(trim($_SESSION['current_user']['username']));
                // Trim whitespace and convert to lowercase for comparison
                $leave_email = strtolower(trim($leave_request['email']));
                $session_email = strtolower(trim($_SESSION['current_user']['email']));
            ?>
                <?php if ($role == 'admin' || ($role == 'user' && $leave_username == $session_username && $leave_email == $session_email)) : ?>
                    <tr class="text-center">
                        <td><?= $leave_id++; ?></td>
                        <?php if ($role == 'admin') : ?>
                            <td><?= $leave_request['username']; ?></td>
                            <td><?= $leave_request['email']; ?></td>
                            <td><?= $leave_request['department']; ?></td>
                        <?php endif; ?>
                        <td><?php echo $leave_request['type']; ?></td>
                        <td><?php echo $leave_request['startDate']; ?></td>
                        <td><?php echo $leave_request['endDate']; ?></td>
                        <td><?php echo $leave_request['description']; ?></td>
                        <td>
                            <?php
                            if (isset($leave_request['status'])) {
                                if ($leave_request['status'] == 1) {
                                    echo '<span class="badge text-bg-warning">Pending</span>';
                                } elseif ($leave_request['status'] == 2) {
                                    echo '<span class="badge text-bg-success">Approved</span>';
                                } elseif ($leave_request['status'] == 3) {
                                    echo '<span class="badge text-bg-danger">Rejected</span>';
                                }
                            } else {
                                echo "Status not available";
                            }
                            ?>
                        </td>
                        <?php if ($role == 'admin') : ?>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-success approveLeave" data-id="<?= $leave_request['id'] ?>">Approve</button>
                                <button type="button" class="btn btn-outline-danger rejectLeave" data-id="<?= $leave_request['id'] ?>">Reject</button>
                            </td>
                        <?php else : ?>
                            <?php if ($leave_request['status'] == 1) : ?>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger deleteLeave" data-id="<?= $leave_request['id'] ?>">Delete</button>
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif;?>


<!-- Total leave List -->
<div class="modal fade" id="totalLeaveModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <table class="table table-striped table-light">
      <thead>
          <tr class="table-success text-center">
              <th scope="col">Leave ID</th>
              <?php if( $role == 'admin'){?>
              <th scope="col">Username</th>
              <th scope="col">Email</th>
              <th scope="col">Department</th>
              <?php }?>
              <th scope="col">Type</th>
              <th scope="col">Start Date</th>
              <th scope="col">End Date</th>
              <th scope="col">Description</th>
              <th scope="col">Status</th>
          </tr>
      </thead>
      <tbody>

          <?php foreach( $leave_requests as $leave_request ): ?>
            <?php if ($role == 'admin' || ($role == 'user' && $leave_username == $session_username && $leave_email == $session_email)) : ?>
          <tr class="text-center"> 
              <td><?php  echo $l++ ?></td>
              <?php if( $role =='admin' ):?>
              <td><?= $leave_request[ 'username' ];?></td>
              <td><?= $leave_request[ 'email' ];?></td>
              <td><?= $leave_request[ 'department' ];?></td>
          <?php endif; ?>
              <td><?php  echo $leave_request[ 'type' ]; ?></td>
              <td><?php  echo $leave_request[ 'startDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'endDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'description' ]; ?></td>
              <td id="<?php echo $leave_request['id']; ?>"> <!-- Add an ID for the status cell -->
            <?php 
              // Check if 'status' key exists in $leave_request
              if(isset($leave_request[ 'status' ] )) {
                // 'status' key exists, so echo its value
                if( $leave_request['status'] == 1 ) {
                  echo '<span class="badge text-bg-warning">Pending</span>';
                } elseif ( $leave_request[ 'status' ] == 2 ) {
                  echo '<span class="badge text-bg-success">Approved</span>';
                } elseif ( $leave_request[ 'status' ] == 3 ) {
                  echo '<span class="badge text-bg-danger">Rejected</span>';
                }
              } else {
                // 'status' key doesn't exist in $leave_request
                echo "Status not available";
              }
            ?>
          </td>
          </tr>
          <?php endif; ?>
          <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Pending List -->
<div class="modal fade" id="pendingModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <table class="table table-striped table-light table-hover">
      <thead>
          <tr class="table-success text-center">
              <th scope="col">Leave ID</th>
              <?php if( $role == 'admin'){?>
              <th scope="col">Username</th>
              <th scope="col">Email</th>
              <th scope="col">Department</th>
              <?php }?>
              <th scope="col">Type</th>
              <th scope="col">Start Date</th>
              <th scope="col">End Date</th>
              <th scope="col">Description</th>
              <th scope="col">Status</th>
              <?php foreach( $leave_requests as $leave_request ):
                if ( !( $role == 'admin' ) || ($role =='user' && $leave_request[ 'status' ] == 1 )) : ?>
              <th scope="col">Actions</th>
              <?php break; endif; ?>
                <?php endforeach; ?>
          </tr>
      </thead>
      <tbody>
          <?php foreach( $leave_requests as $leave_request ): ?>
            <?php if ( ( $role == 'admin' && $leave_request[ 'status' ] == 1 ) || ($role == 'user' && $leave_username == $session_username && $leave_email == $session_email) ) : ?>
          <tr class="text-center"> 
              <td><?php  echo $i++ ?></td>
              <?php if( $role =='admin' ):?>
              <td><?= $leave_request[ 'username' ];?></td>
              <td><?= $leave_request[ 'email' ];?></td>
              <td><?= $leave_request[ 'department' ];?></td>
          <?php endif; ?>
              <td><?php  echo $leave_request[ 'type' ]; ?></td>
              <td><?php  echo $leave_request[ 'startDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'endDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'description' ]; ?></td>
              <td id="<?php echo $leave_request['id']; ?>"> <!-- Add an ID for the status cell -->
            <?php 
              // Check if 'status' key exists in $leave_request
              if(isset($leave_request[ 'status' ] )) {
                // 'status' key exists, so echo its value
                if( $leave_request['status'] == 1 ) {
                  echo '<span class="badge text-bg-warning">Pending</span>';
                } elseif ( $leave_request[ 'status' ] == 2 ) {
                  echo '<span class="badge text-bg-success">Approved</span>';
                } elseif ( $leave_request[ 'status' ] == 3 ) {
                  echo '<span class="badge text-bg-danger">Rejected</span>';
                }
              } else {
                // 'status' key doesn't exist in $leave_request
                echo "Status not available";
              }
            ?>
          </td>
          </tr>
          <?php endif; ?>
          <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Approved List -->
<div class="modal fade" id="approvedModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <table class="table table-striped table-light table-hover">
      <thead>
          <tr class="table-success text-center">
              <th scope="col">Leave ID</th>
              <?php if( $role == 'admin'){?>
              <th scope="col">Username</th>
              <th scope="col">Email</th>
              <th scope="col">Department</th>
              <?php }?>
              <th scope="col">Type</th>
              <th scope="col">Start Date</th>
              <th scope="col">End Date</th>
              <th scope="col">Description</th>
              <th scope="col">Status</th>
              <?php foreach( $leave_requests as $leave_request ):
                if ( !( $role == 'admin' ) || ($role =='user' && $leave_request[ 'status' ] == 1 )) : ?>
              <th scope="col">Actions</th>
              <?php break; endif; ?>
                <?php endforeach; ?>
          </tr>
      </thead>
      <tbody>
          <?php foreach( $leave_requests as $leave_request ): ?>
            <?php if ( ( $role == 'admin' && $leave_request[ 'status' ] == 2 ) || ($role == 'user' && $leave_username == $session_username && $leave_email == $session_email) ) : ?>
          <tr class="text-center"> 
              <td><?php  echo $j++ ?></td>
              <?php if( $role =='admin' ):?>
              <td><?= $leave_request[ 'username' ];?></td>
              <td><?= $leave_request[ 'email' ];?></td>
              <td><?= $leave_request[ 'department' ];?></td>
          <?php endif; ?>
              <td><?php  echo $leave_request[ 'type' ]; ?></td>
              <td><?php  echo $leave_request[ 'startDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'endDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'description' ]; ?></td>
              <td id="<?php echo $leave_request['id']; ?>"> <!-- Add an ID for the status cell -->
            <?php 
              // Check if 'status' key exists in $leave_request
              if(isset($leave_request[ 'status' ] ) ) {
                // 'status' key exists, so echo its value
                if( $leave_request['status'] == 1 ) {
                  echo '<span class="badge text-bg-warning">Pending</span>';
                } elseif ( $leave_request[ 'status' ] == 2 ) {
                  echo '<span class="badge text-bg-success">Approved</span>';
                } elseif ( $leave_request[ 'status' ] == 3 ) {
                  echo '<span class="badge text-bg-danger">Rejected</span>';
                }
              } else {
                // 'status' key doesn't exist in $leave_request
                echo "Status not available";
              }
            ?>
          </td>
          </tr>
          <?php endif;
         endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Rejected List -->
<div class="modal fade" id="rejectedModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <table class="table table-striped table-light table-hover">
      <thead>
          <tr class="table-success text-center">
              <th scope="col">Leave ID</th>
              <?php if( $role == 'admin'){?>
              <th scope="col">Username</th>
              <th scope="col">Email</th>
              <th scope="col">Department</th>
              <?php }?>
              <th scope="col">Type</th>
              <th scope="col">Start Date</th>
              <th scope="col">End Date</th>
              <th scope="col">Description</th>
              <th scope="col">Status</th>
              <?php foreach( $leave_requests as $leave_request ):
                if ( !( $role == 'admin' ) || ($role =='user' && $leave_request[ 'status' ] == 1 )) : ?>
              <th scope="col">Actions</th>
              <?php break; endif; ?>
                <?php endforeach; ?>
          </tr>
      </thead>
      <tbody>
          <?php foreach( $leave_requests as $leave_request ): ?>
            <?php if ( ( $role == 'admin' && $leave_request[ 'status' ] == 3 ) || ($role == 'user' && $leave_username == $session_username && $leave_email == $session_email) ) : ?>
          <tr class="text-center"> 
              <td><?php  echo $r++ ?></td>
              <?php if( $role =='admin' ):?>
              <td><?= $leave_request[ 'username' ];?></td>
              <td><?= $leave_request[ 'email' ];?></td>
              <td><?= $leave_request[ 'department' ];?></td>
          <?php endif; ?>
              <td><?php  echo $leave_request[ 'type' ]; ?></td>
              <td><?php  echo $leave_request[ 'startDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'endDate' ]; ?></td>
              <td><?php  echo $leave_request[ 'description' ]; ?></td>
              <td id="<?php echo $leave_request['id']; ?>"> <!-- Add an ID for the status cell -->
            <?php 
              // Check if 'status' key exists in $leave_request
              if(isset($leave_request[ 'status' ] )) {
                // 'status' key exists, so echo its value
                if( $leave_request['status'] == 1 ) {
                  echo '<span class="badge text-bg-warning">Pending</span>';
                } elseif ( $leave_request[ 'status' ] == 2 ) {
                  echo '<span class="badge text-bg-success">Approved</span>';
                } elseif ( $leave_request[ 'status' ] == 3 ) {
                  echo '<span class="badge text-bg-danger">Rejected</span>';
                }
              } else {
                // 'status' key doesn't exist in $leave_request
                echo "Status not available";
              }
            ?>
          </td>
          </tr>
          <?php endif;
         endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if( $role == 'admin' ){?>
<div class="row">
    <div class="col-6">

        <?php
        // Step 1: Initialize an array to store leave request counts for each month
        $leaveCountsByMonth = [];

        // Step 2: Loop through leave requests and count leave requests for each month
        foreach ($leave_requests as $leave_request) {
            $startDate = new DateTime($leave_request['startDate']);
            $monthYear = $startDate->format('F Y');

            // Increment the count for the month or initialize it if not present
            if (isset($leaveCountsByMonth[$monthYear])) {
                $leaveCountsByMonth[$monthYear]++;
            } else {
                $leaveCountsByMonth[$monthYear] = 1;
            }
        }
        // Step 3: Prepare data for the line chart
        $months = [];
        $leaveCounts = [];
        
        foreach ($leaveCountsByMonth as $month => $count) {
            $months[] = $month;
            $leaveCounts[] = $count;
        }
        ?>

        <!-- Step 4: Render the line chart using a charting library like Chart.js -->
        <div class="my-3">
            <canvas id="leaveChart"></canvas>
        </div>

    </div>
    <div class="col-6">
        <?php // Initialize arrays to store leave type and count
        $leaveTypes = [];
        $leaveCounters = [];

        // Iterate through leave requests to count leave types
        foreach ($leave_requests as $leave_request) {
            $type = $leave_request['type'];
            if (!isset($leaveTypes[$type])) {
                $leaveTypes[$type] = 1;
            } else {
                $leaveTypes[$type]++;
            }
        }

        // Extract leave types and counts for the pie chart
        $leaveTypeLabels = array_keys($leaveTypes);
        $leaveTypeCounts = array_values($leaveTypes);
        ?>
    <div class="my-3">
        <canvas id="leavePieChart" width="400" height="400"></canvas>
    </div>
    </div>
</div>
<?php }?>


<script>
    var ctx = document.getElementById('leaveChart').getContext('2d');
    var leaveChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($months) ?>,
            datasets: [{
                label: 'Leave Requests',
                data: <?= json_encode($leaveCounts) ?>,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Get data from PHP
    var leaveTypeLabels = <?php echo json_encode($leaveTypeLabels); ?>;
    var leaveTypeCounts = <?php echo json_encode($leaveTypeCounts); ?>;

    // Render pie chart
    var pie_chart = document.getElementById('leavePieChart').getContext('2d');
    var leavePieChart = new Chart(pie_chart, {
        type: 'pie',
        data: {
            labels: leaveTypeLabels,
            datasets: [{
                label: 'Leave Types',
                data: leaveTypeCounts,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Leave Types'
            }
        }
    });
</script>

