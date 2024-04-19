<?php 
  $role = $_SESSION[ 'current_user' ][ 'role' ]; 
  $leave_id = 1;
  $i = 1;
  $j = 1;
  $l = 1;
  $r = 1;
  
?>
<?php if( $role == 'user') : ?>
<div class="my-3 text-center">
    <button id="createLeaveBtn" class="btn btn-outline-info">Leave Apply</button>
</div>
<?php else: ?>
  <div class="my-3 text-center d-flex justify-content-evenly">
    <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves </br><?= $totalLeaveCount ?></button>
    <button id="pendingBtn" class="btn btn-outline-warning">Pending </br> <?= $pendingLeaveCount ?></button>
    <button id="approvedBtn" class="btn btn-outline-success">Approved </br> <?= $approvedLeaveCount ?></button>
    <button id="rejectedBtn" class="btn btn-outline-danger">Rejected </br> <?= $rejectedLeaveCount ?></button>
  </div>
  <?php endif; ?>


  
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
          <input type="hidden" id="username" name="username" value=" <?php echo $_SESSION[ 'current_user'  ][ 'username' ] ?> ">
          <input type="hidden" id="email" name="email" value=" <?php echo $_SESSION[ 'current_user'][ 'email' ] ?>">
          <input type="hidden" id="department" name="department" value=" <?php echo $_SESSION[ 'current_user'][ 'department' ] ?>">
          <div class="form-group">
              <label for="type">Leave Type</label>
              <input type="text" class="form-control" id="type" name="type" placeholder="Enter Leave Type">
          </div>
          <div class="form-group">
							<label class="form-control-label">Start Date</label>
							<input type="date" name="startDate" class="form-control" />
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
              <input type="submit" class="btn btn-success" value="Apply"></input>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Leave table -->
<div class="my-3">
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
