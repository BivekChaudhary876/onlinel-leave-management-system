<?php 
  $is_admin = $_SESSION[ 'current_user' ][ 'role' ] == 'admin'; 
  $is_user = $_SESSION[ 'current_user' ][ 'role' ] == 'user'; 
$leave_id=1;
$i = 1;
$j = 1;
$l = 1;
$r = 1;

?>
  
<div class="my-3">
    <?php if ($is_admin) { ?>
            <div class="my-3 text-center">
                <h1>Check Leave Requests</h1>
            </div>
            <!-- Total and status counts -->
            <div class="row">
                <div class="my-3 text-center d-flex justify-content-evenly">
                    <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br> <?= $total_leave_status ?></button>
                    <button id="pendingBtn" class="btn btn-outline-warning">Pending<br> <?= $pending_status ?></button>
                    <button id="approvedBtn" class="btn btn-outline-success">Approved<br> <?= $approved_status ?></button>
                    <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br> <?= $rejected_status ?></button>
                </div>
            </div>

    <?php } elseif ($is_user) { ?>
            <div class="text-center my-3">
                <h2>Leave Requests</h2>
                
            </div>

             <!-- Total and status counts -->
            <div class="row">
                <div class="my-3 text-center d-flex justify-content-evenly">
                    <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br> <?= $total_leave_status ?></button>
                    <button id="pendingBtn" class="btn btn-outline-warning">Pending<br> <?= $pending_status ?></button>
                    <button id="approvedBtn" class="btn btn-outline-success">Approved<br> <?= $approved_status ?></button>
                    <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br> <?= $rejected_status ?></button>
                </div>
            </div>
    <?php } ?>
</div>

<!-- Total leave List -->
<div class="modal fade" id="totalLeaveModal">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <table class="table table-striped table-light table-hover">
      <thead>
        <tr class="table-success text-center">
            <th scope="col">S.No</th>
            <?php if( $is_admin){?>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Department</th>
            <?php }?>
            <th scope="col">Type</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach( $leave_requests as $leave_request ):?>

          <?php if ($is_admin || ($is_user && $leave_request['username'] == $_SESSION['current_user']['username'])) : ?>
        <tr class="text-center"> 
            <td><?php  echo $l++ ?></td>
            <?php if( $is_admin):?>
            <td><?= $leave_request[ 'username' ];?></td>
            <td><?= $leave_request[ 'email' ];?></td>
            <td><?= $leave_request[ 'department' ];?></td>
        <?php endif; ?>
            <td><?php  echo $leave_request[ 'leave_type' ]; ?></td>
            <td><?php  echo $leave_request[ 'from_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'to_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'description' ]; ?></td>
            <td><?= get_status_badge($leave_request['status']) ?></td>
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
            <th scope="col">S.No</th>
            <?php if( $is_admin){?>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Department</th>
            <?php }?>
            <th scope="col">Type</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach( $leave_requests as $leave_request ):?>

          <?php if ($is_admin && $leave_request['status'] == 'pending' || ($is_user && $leave_request['username'] == $_SESSION['current_user']['username'] )) : ?>
        <tr class="text-center"> 
            <td><?php  echo $i++ ?></td>
            <?php if( $is_admin):?>
            <td><?= $leave_request[ 'username' ];?></td>
            <td><?= $leave_request[ 'email' ];?></td>
            <td><?= $leave_request[ 'department' ];?></td>
        <?php endif; ?>
            <td><?php  echo $leave_request[ 'leave_type' ]; ?></td>
            <td><?php  echo $leave_request[ 'from_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'to_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'description' ]; ?></td>
            <td><?= $this->model->getStatusBadge($leave_request['status']) ?></td>
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
            <th scope="col">S.No</th>
            <?php if( $is_admin ){?>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Department</th>
            <?php }?>
            <th scope="col">Type</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach( $leave_requests as $leave_request ):?>
          <?php if ( $is_admin && $leave_request[ 'status' ] == 'approved' || ($is_user && $leave_request['username'] == $_SESSION['current_user'][ 'username' ] ) ) : ?>
        <tr class="text-center"> 
            <td><?php  echo $j++ ?></td>
            <?php if( $is_admin ):?>
            <td><?= $leave_request[ 'username' ];?></td>
            <td><?= $leave_request[ 'email' ];?></td>
            <td><?= $leave_request[ 'department' ];?></td>
        <?php endif; ?>
            <td><?php  echo $leave_request[ 'leave_type' ]; ?></td>
            <td><?php  echo $leave_request[ 'from_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'to_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'description' ]; ?></td>
            <td><?= $this->model->getStatusBadge($leave_request['status']) ?></td>
        
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
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
            <th scope="col">S.No</th>
            <?php if( $is_admin){?>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Department</th>
            <?php }?>
            <th scope="col">Type</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach( $leave_requests as $leave_request ):?>
          <?php if (( $is_admin && $leave_request[ 'status' ] == 'rejected' ) || ( $is_user && $leave_request['username'] == $_SESSION['current_user']['username'] ) ) : ?>
        <tr class="text-center"> 
            <td><?php  echo $r++ ?></td>
            <?php if( $is_admin ):?>
            <td><?= $leave_request[ 'username' ];?></td>
            <td><?= $leave_request[ 'email' ];?></td>
            <td><?= $leave_request[ 'department' ];?></td>
        <?php endif; ?>
            <td><?php  echo $leave_request[ 'leave_type' ]; ?></td>
            <td><?php  echo $leave_request[ 'from_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'to_date' ]; ?></td>
            <td><?php  echo $leave_request[ 'description' ]; ?></td>
            <td><?= $this->model->getStatusBadge($leave_request['status']) ?></td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
    </table>
  </div>


</div>


<?php if( $is_admin ){?>
  <div class="row">
      <div class="col-6">

          <?php
          // Step 1: Initialize an array to store leave request counts for each month
          $leaveCountsByMonth = [];

          // Step 2: Loop through leave requests and count leave requests for each month
          foreach ( $leave_requests as $leave_request ) {
              $from = new DateTime( $leave_request['from_date'] );
              $monthYear = $from->format('F Y');

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
              $type = $leave_request['leave_type'];
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
  $(document).ready(function(){
    $('#pendingBtn').click(function () {
		// Show the modal
		$('#pendingModal').modal('show')
	})

	$('#approvedBtn').click(function () {
		// Show the modal
		$('#approvedModal').modal('show')
	})

	$('#rejectedBtn').click(function () {
		// Show the modal
		$('#rejectedModal').modal('show')
	})
  })
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

