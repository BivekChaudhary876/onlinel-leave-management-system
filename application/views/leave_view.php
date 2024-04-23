<?php 
  $is_admin = $_SESSION[ 'current_user' ][ 'role' ] == 'admin'; 
  $is_user = $_SESSION[ 'current_user' ][ 'role' ] == 'user'; 
  $leave_id = 1;
  $i = 1;
  $j = 1;
  $l = 1;
  $r = 1;

?>
<?php if( $is_user ) : ?>
<div class="my-3 text-center">
    <button id="createLeaveBtn" class="btn btn-outline-info">Leave Apply</button>
</div>
<?php else: ?>
  <div class="my-3 text-center">
    <div class="col">
        <div class="my-3 text-end">
            <form method="post">
                <select name="selected_user" class="p-1 btn border-success rounded-start rounded-end">
                    <option value="0">Select User</option>
                    <?php
                        $selectedUser = isset($_POST['selected_user']) ? $_POST['selected_user'] : '0';
                        
                        foreach ($users as $user) : 
                            $isSelected = ($user['id'] == $selectedUser) ? 'selected' : '';
                    ?>
                            <option value="<?= $user['id'] ?>" <?= $isSelected ?> ><?= $user['username'] ?></option>
                        <?php endforeach; ?>
                </select>


                <input type="date" name="from" class="p-1 btn border-success rounded-start rounded-end" placeholder="From" 
                    value="<?= isset($_POST['from']) ? $_POST['from'] : '' ?>" />
                <input type="date" name="to" class="p-1 btn border-success rounded-start rounded-end" placeholder="To"
                    value="<?= isset($_POST['to']) ? $_POST['to'] : '' ?>" />
                <input type="submit" value="Filter" class="p-1 btn btn-outline-success">
            </form>
        </div>
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
          <input type="hidden" id="user_id" name="user_id" value=" <?php echo $_SESSION[ 'current_user'  ][ 'id' ] ?> ">
          <input type="hidden" id="type_id" name="type_id" value="<?php echo $_SESSION['current_user']['id']; ?>">
          <div class="form-group">
							<label class="form-control-label">Leave Type</label>
							<select name="leaveType" class="form-control">
								<option value="">Select Leave Type</option>
								<?php foreach($leave_requests as $leave_request ): ?>
                      <option value="<?= $leave_request[ 'id' ] ?>"><?= $leave_request[ 'type' ]?></option>
                <?php endforeach; ?>
							</select>
						</div>
          <div class="form-group">
							<label for="from" class="form-control-label">From</label>
							<input type="date" class="form-control" name="from" placeholder="Enter Leave From"/>
						</div>
          <div class="form-group">
              <label for="to">To</label>
              <input type="date" class="form-control" id="to" name="to" placeholder="Enter Leave To"/>
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
            <th scope="col">S.No</th>
            <?php if( $is_admin ):?>
              <th scope="col">Username</th>
              <th scope="col">Email</th>
              <th scope="col">Department</th>
            <?php endif;?>
            <th scope="col">Type</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Description</th>
            <th scope="col">Status</th>

            <?php foreach( $leaves as $leave_request ):

                    if ( $is_admin || ($is_user && $pending_status )) : ?>
                      <th scope="col">Actions</th>

                      <?php break; 

                    endif;

                endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $leaves as $leave ) : ?>
                    <?php if ( $is_admin || ($is_user && $leave['username'] == $_SESSION['current_user']['username']) ) : ?>
                            <tr class="text-center"> 
                                <td><?php  echo $leave_id++ ?></td>
                                <?php if( $is_admin ):?>
                                      <td><?= $leave[ 'username' ];?></td>
                                      <td><?= $leave[ 'email' ];?></td>
                                      <td><?= $leave[ 'department' ];?></td>
                                <?php endif; ?>
                                <td><?php  echo $leave[ 'leave_type' ]; ?></td>
                                <td><?php  echo $leave[ 'from' ]; ?></td>
                                <td><?php  echo $leave[ 'to' ]; ?></td>
                                <td><?php  echo $leave[ 'description' ]; ?></td>
                                <td><?= $this->model->getStatusBadge($leave['status']) ?></td>

                                <?php if( $is_admin): ?>
                                      <td class="text-center">
                                        <button type="button" class="btn btn-outline-success approveLeave" data-id="<?= $leave[ 'leave_request_id' ] ?>">Approve</button>
                                        <button type="button" class="btn btn-outline-danger rejectLeave" data-id="<?= $leave[ 'leave_request_id' ] ?>">Reject</button>
                                      </td>
                                  <?php else: ?>

                                  <?php if( $pending_status ): ?>
                                        <td class="text-center">
                                          <button type="button" class="btn btn-outline-danger deleteLeave" data-id="<?= $leave[ 'leave_request_id' ] ?>">Delete</button>
                                        </td>
                                <?php endif; ?>

                              <?php endif; ?>
                            </tr>
                    <?php endif; ?>
          <?php endforeach; ?>
    </tbody>
</table>
</div>

