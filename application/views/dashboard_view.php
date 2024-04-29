
  
<div class="my-3">
    <?php if ( is_admin() ) :?>
            <div class="my-3 text-center">
                <h1>Check Leave Requests</h1>
            </div>
            <!-- Total and status counts -->
            <div class="row">
                <div class="my-3 text-center d-flex justify-content-evenly">
                    <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br> <?= $total_leaves ?></button>
                    <button id="pendingBtn" class="btn btn-outline-warning">Pending<br> <?= $total_pending ?></button>
                    <button id="approvedBtn" class="btn btn-outline-success">Approved<br> <?= $total_approved ?></button>
                    <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br> <?= $total_rejected ?></button>
                </div>
            </div>

    <?php else: ?>
            <div class="text-center my-3">
                <h2>Leave Requests</h2>
                
            </div>

             <!-- Total and status counts -->
            <div class="row">
                <div class="my-3 text-center d-flex justify-content-evenly">
                    <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br> <?= $total_leaves ?></button>
                    <button id="pendingBtn" class="btn btn-outline-warning">Pending<br> <?= $total_pending ?></button>
                    <button id="approvedBtn" class="btn btn-outline-success">Approved<br> <?= $total_approved ?></button>
                    <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br> <?= $total_rejected ?></button>
                </div>
            </div>
    <?php endif; ?>
</div>


<?php 
// Total leave List
$data = [
    "current_status" => ['pending','approved','rejected']
];

leave_list([
    "modal-id"       => 'totalLeaveModal',  
    "model"          => $total_leave_requests,
    "current_status" => $data['current_status'][0]
]);

// Pending List
leave_list([
    "modal-id"       => 'pendingModal',
    "model"          => $total_leave_requests,
    "current_status" => 'pending'
]);

// Approved List
leave_list([
    "modal-id"       => 'approvedModal',
    "model"          => $total_leave_requests,
    "current_status" => 'approved'
]);

// Rejected List
leave_list([
    "modal-id"       => 'rejectedModal',
    "model"          => $total_leave_requests,
    "current_status" => 'rejected'
]);?>




<?php if( is_admin() ){?>
  <div class="row">
      <div class="col-6">

          <?php
          // Initialize an array to store leave request counts for each month
          $leaveCountsByMonth = [];

          // Loop through leave requests and count leave requests for each month
          foreach ( $total_leave_requests as $leave_request ) {
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
          foreach ($total_leave_requests as $leave_request) {
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


