<!-- Leave Apply -->
<div class="modal fade" id="createLeaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Leave Apply</h5>
      </div>
      <div class="modal-body">
        <!-- Form for creating a new user -->
        <form method="POST" action="index.php?c=leave&m=save"">
          <input type="hidden" id="leaveid" name="id">
            <div class="form-group">
                <label for="type">Leave Type</label>
                <input type="text" class="form-control" id="type" name="type" placeholder="Enter Leave Type">
            </div>
            <div class="form-group">
                <label for="startDate">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Enter Leave Start">
            </div>
            <div class="form-group">
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" placeholder="Enter Leave End">
            </div>
            <div class="form-group">
                <label for="description">Descriptions</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Descriptions"></textarea>
            </div>
            <!-- <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" name="status" placeholder="Status">
            </div> -->

            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-success editLeave">Apply</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if( $_SESSION['current_user']['role'] == 'user') { ?>
<div class="my-3 text-center">
    <button id="createLeaveBtn" class="btn btn-outline-success">Add Leave</button>
</div>
<?php } ?>

<div class="my-3">
    <table class="table table-striped table-light">
    <thead>
        <tr class="table-success text-center">
            <th scope="col">Leave ID</th>
            <?php if( $_SESSION['current_user']['role'] == 'admin'){?>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <?php }?>
            <th scope="col">Type</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Descriptions</th>
            <th scope="col">Status</th>
            <?php if( $_SESSION['current_user']['role']=='user' ){?>
            <th scope="col">Actions</th>
            <?php }?>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $leave_requests as $k => $leave_request ): ?>
        <tr class="text-center">
            <td><?php  echo ++$k ?></td>
            <?php if($_SESSION['current_user']['role']=='admin' ){?>
            <td><?= $_SESSION['current_user']['username'];?></td>
            <td><?= $_SESSION['current_user']['email'];?></td>
            <td><?php  echo $leave_request[ 'type' ]; ?></td>
            <td><?php  echo $leave_request[ 'startDate' ]; ?></td>
            <td><?php  echo $leave_request[ 'endDate' ]; ?></td>
            <td><?php  echo $leave_request[ 'description' ]; ?></td>
            <td id="<?php echo $leave_request['id']; ?>_status"> <!-- Add an ID for the status cell -->
          <?php 
            // Check if 'status' key exists in $leave_request
            if(isset($leave_request[ 'status' ] )) {
              // 'status' key exists, so echo its value
              if( $leave_request['status'] == 1 ) {
                echo "Pending";
              } elseif ( $leave_request[ 'status' ] == 2 ) {
                echo "Approved";
              } elseif ( $leave_request[ 'status' ] == 3 ) {
                echo "Rejected";
              }
            } else {
              // 'status' key doesn't exist in $leave_request
              echo "Status not available";
            }
          ?>
          <?php if($_SESSION['current_user']['role'] == 'admin'): ?>
            <!-- Status update dropdown for admins -->
            <select class="form-control" name="status" onchange="leave_update_status('<?php echo $leave_request['id']; ?>', this.value)">
              <option value="">Update Status</option>
              <option value="1">Pending</option>
              <option value="2">Approved</option>
              <option value="3">Rejected</option>
            </select>
          <?php endif; ?>
        </td>
            <?php }else{ ?>
            <td><?php  echo $leave_request[ 'type' ]; ?></td>
            <td><?php  echo $leave_request[ 'startDate' ]; ?></td>
            <td><?php  echo $leave_request[ 'endDate' ]; ?></td>
            <td><?php  echo $leave_request[ 'description' ]; ?></td>
            <td id="<?php echo $leave_request['id']; ?>_status"> <!-- Add an ID for the status cell -->
          <?php 
            // Check if 'status' key exists in $leave_request
            if(isset($leave_request[ 'status' ] )) {
              // 'status' key exists, so echo its value
              if( $leave_request['status'] == 1 ) {
                echo "Pending";
              } elseif ( $leave_request[ 'status' ] == 2 ) {
                echo "Approved";
              } elseif ( $leave_request[ 'status' ] == 3 ) {
                echo "Rejected";
              }
            } else {
              // 'status' key doesn't exist in $leave_request
              echo "Status not available";
            }
          ?></td>
            
            <td class="text-center">
              <button type="button" class="btn btn-outline-danger deleteLeave" data-id="<?= $leave_request[ 'id' ] ?>">Delete</button>
            </td>
            <?php }?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<script>
  function leave_update_status(id,select_value){
    alert(select_value);
  }
</script>
