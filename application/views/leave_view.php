<?php $role = $_SESSION[ 'current_user' ][ 'role' ];?>

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

            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-success editLeave">Apply</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if( $role == 'user') { ?>
<div class="my-3 text-center">
    <button id="createLeaveBtn" class="btn btn-outline-success">Add Leave</button>
</div>
<?php } ?>

<div class="my-3">
    <table class="table table-striped table-light">
    <thead>
        <tr class="table-success text-center">
            <th scope="col">Leave ID</th>
            <?php if( $role == 'admin'){?>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <?php }?>
            <th scope="col">Type</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>
            <?php if ( $role == "admin" ) : ?>
            <th scope="col">Actions</th>
              <?php endif; ?>
            <?php foreach( $leave_requests as $i => $leave_request ):
               if ( $role =='user' && $leave_request[ 'status' ] == 1 ) : ?>
            <th scope="col">Actions</th>
              <?php endif; ?>
              <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>

        <?php foreach( $leave_requests as $k => $leave_request ): ?>
          
        <tr class="text-center">
            <td><?php  echo ++$k ?></td>
            <?php if( $role =='admin' ):?>
            <td><?= $_SESSION['current_user']['username'];?></td>
            <td><?= $_SESSION['current_user']['email'];?></td>
            <?php endif;?>
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
        </td>
          
        <?php if( $role =='admin'): ?>
            <td class="text-center">
              <button type="button" class="btn btn-outline-danger approveLeave" data-id="<?= $leave_request[ 'id' ] ?>">Approve</button>
              <button type="button" class="btn btn-outline-danger rejectLeave" data-id="<?= $leave_request[ 'id' ] ?>">Reject</button>
            </td>
            <?php else: ?>

              <?php if( $leave_request['status']==1){?>
            <td class="text-center">
              <button type="button" class="btn btn-outline-danger deleteLeave" data-id="<?= $leave_request[ 'id' ] ?>">Delete</button>
            </td>
            <?php }?>
            <?php endif; ?>
        </tr>
       
        <?php endforeach; ?>
    </tbody>
</table>
</div>
