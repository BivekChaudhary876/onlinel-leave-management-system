<div class="my-3 text-center">
    <h1>Dashboard</h1>
</div>
<div class="row py-4" id="droppable"style="gap:100px">
    <div class="col-3" id="col1" style="border:1px solid green;">
        <p>widget 1</p>
    </div>
    <div class="col-3" id="col2"  style="border:1px solid orange;">
        <p>widget 2</p>
    </div>
    <div class="col-3" id="col3"  style="border:1px solid blue;">
        <p>widget 3</p>
    </div>
</div>

<div id="draggable-h">
    <p>hello</p>
</div>

  
<div class="my-3">
    <?php if ( is_admin() ) :?>
            <!-- Total and status counts -->
            <div class="row">
                <div class="my-3 text-center d-flex justify-content-evenly">
                    <p id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br> <?php echo $total_leaves ?></p>
                    <p id="pendingBtn" class="btn btn-outline-warning">Pending<br> <?php echo $total_pending ?></p>
                    <p id="approvedBtn" class="btn btn-outline-success">Approved<br> <?php echo $total_approved ?></p>
                    <p id="rejectedBtn" class="btn btn-outline-danger">Rejected<br> <?php echo $total_rejected ?></p>
                </div>
            </div>

    <?php else: ?>
             <!-- Total and status counts -->
            <div class="row">
                <div class="my-3 text-center d-flex justify-content-evenly">
                    <p id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br> <?php echo $total_leaves ?></p>
                    <p id="pendingBtn" class="btn btn-outline-warning">Pending<br> <?php echo $total_pending ?></p>
                    <p id="approvedBtn" class="btn btn-outline-success">Approved<br> <?php echo $total_approved ?></p>
                    <p id="rejectedBtn" class="btn btn-outline-danger">Rejected<br> <?php echo $total_rejected ?></p>
                </div>
            </div>
    <?php endif; ?>
</div>

<?php if( is_admin() ) :?>
  <div class="row">
      <div id="line" class="col-6">

          <?php
          $leaveCountsByMonth = [];

          foreach ( $total_leave_requests as $leave_request ) :
              $from = new DateTime( $leave_request[ 'from_date' ] );
              $monthYear = $from->format('F Y');

              if ( isset( $leaveCountsByMonth[ $monthYear ] ) ) :
                  $leaveCountsByMonth[ $monthYear ]++;
               else :
                  $leaveCountsByMonth[ $monthYear ] = 1;
               endif;
            endforeach;
          $months = [];
          $leaveCounts = [];
          
          foreach ( $leaveCountsByMonth as $month => $count ) :
              $months[] = $month;
              $leaveCounts[] = $count;
          endforeach;
          ?>

          <div class="my-3">
              <canvas id="leaveChart"></canvas>
          </div>

      </div>

      <div class="col-6" id="pie">
          <?php 
          $leaveTypes = [];
          $leaveCounters = [];

          foreach ( $total_leave_requests as $leave_request ) :
              $type = $leave_request[ 'leave_type' ];
              if ( !isset( $leaveTypes[ $type ] ) ) :
                  $leaveTypes[ $type ] = 1;
               else :
                  $leaveTypes[ $type ]++;
              endif;
            endforeach;

          $leaveTypeLabels = array_keys( $leaveTypes );
          $leaveTypeCounts = array_values( $leaveTypes );
          ?>
      <div class="my-3">
          <canvas id="leavePieChart" width="200" height="200"></canvas>
      </div>
      </div>
  </div>
  <?php endif;?>

<script>
  
    var ctx = document.getElementById('leaveChart').getContext('2d');
    var leaveChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($months) ?>,
            datasets: [{
                label: 'Leave Requests',
                data: <?= json_encode($leaveCounts) ?>,
                fill: false,
                backgroundColor:'green',
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
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
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
    
$(document).ready(function () {
    // Make the items draggable
    $("#draggable-h, #totalLeaveBtn, #pendingBtn, #approvedBtn, #rejectedBtn").draggable({
        containment: 'document',
        revert: "invalid",
        stack: ".draggable",
        zIndex: 1000,
    });

    // Set up sortable and droppable behavior for widgets
    $(".col-3").sortable({
        connectWith: ".col-3",
        placeholder: "sortable-placeholder",
        update: saveWidgetOrder,
    }).disableSelection();

    $(".col-3").droppable({
        accept: "#draggable-h, #totalLeaveBtn, #pendingBtn, #approvedBtn, #rejectedBtn",
        drop: function (event, ui) {
            var droppedItem = ui.draggable;
            $(this).append(droppedItem);
            saveWidgetOrder();
        },
    });

    // Function to save widget order to local storage
    function saveWidgetOrder() {
        let widgetOrder = {
            col1: $("#col1").sortable("toArray"),
            col2: $("#col2").sortable("toArray"),
            col3: $("#col3").sortable("toArray"),
            droppable: $("#droppable").sortable("toArray"), // added the drop container
        };

        localStorage.setItem("widgetOrder", JSON.stringify(widgetOrder));
    }

    // On page load, initialize the widgets based on stored order
    let savedWidgetOrder = localStorage.getItem("widgetOrder");
    if (savedWidgetOrder) {
        let order = JSON.parse(savedWidgetOrder);

        order.col1.forEach(function (widget) {
            $("#" + widget).appendTo("#col1");
        });
        order.col2.forEach(function (widget) {
            $("#" + widget).appendTo("#col2");
        });
        order.col3.forEach(function (widget) {
            $("#" + widget).appendTo("#col3");
        });
        if (order.droppable) {
            order.droppable.forEach(function (widget) {
                $("#" + widget).appendTo("#droppable");
            });
        }
    }

    $("#droppable").droppable({
        accept: "#totalLeaveBtn",
        drop: function (event, ui) {
            alert("Dropped on Drop!");
            saveWidgetOrder();
        },
    });

    // Additional code for dragging out from the droppable container
    $("#droppable").sortable({
        connectWith: ".col-3",
        placeholder: "sortable-placeholder",
        update: saveWidgetOrder,
    }).disableSelection();

    if (localStorage.getItem("dragDropped") === "true") {
        $("#draggable-h, #totalLeaveBtn, #pendingBtn, #approvedBtn, #rejectedBtn").appendTo("#droppable").css({
            top: 0,
            left: 0,
        });
        alert("Drag was previously dropped and re-initialized.");
    }
    $("#draggable-h, #totalLeaveBtn, #pendingBtn, #approvedBtn, #rejectedBtn").draggable({
        revert: function (droppable) {
            return !droppable;
        }
    });
});


</script>


