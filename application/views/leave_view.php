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


                <input type="date" name="from_date" class="p-1 btn border-success rounded-start rounded-end" placeholder="From" 
                    value="<?= isset($_POST['from_date']) ? $_POST['from_date'] : '' ?>" />
                <input type="date" name="to" class="p-1 btn border-success rounded-start rounded-end" placeholder="To"
                    value="<?= isset($_POST['to_date']) ? $_POST['to_date'] : '' ?>" />
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
								<?php foreach($leave_types as $type ): ?>
                      <option value="<?= $type[ 'id' ] ?>"><?= $type[ 'name' ]?></option>
                <?php endforeach; ?>
							</select>
						</div>
          <div class="form-group">
							<label for="from_date" class="form-control-label">From</label>
							<input type="date" class="form-control" name="from_date" placeholder="Enter Leave From"/>
						</div>
          <div class="form-group">
              <label for="to_date">To</label>
              <input type="date" class="form-control" id="to_date" name="to_date" placeholder="Enter Leave To"/>
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
            <th scope="col">Created Date</th>
            <th scope="col">Status</th>

            <?php foreach( $leaves as $leave ):

                    if ( $is_admin || ($is_user && $leave['status'] == 'pending' )) : ?>
                      <th scope="col">Actions</th>

                      <?php break; 

                    endif;

                endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $leaves as $leave ) : ?>
              <tr class="text-center"> 
                  <td><?php  echo $leave_id++ ?></td>
                  <?php if( $is_admin ):?>
                        <td><?= $leave[ 'username' ];?></td>
                        <td><?= $leave[ 'email' ];?></td>
                        <td><?= $leave[ 'department' ];?></td>
                  <?php endif; ?>
                  <td><?php  echo $leave[ 'leave_type' ]; ?></td>
                  <td><?php  echo $leave[ 'from_date' ]; ?></td>
                  <td><?php  echo $leave[ 'to_date' ]; ?></td>
                  <td><?php  echo $leave[ 'description' ]; ?></td>
                  <td><?php  echo $leave[ 'created_date' ]; ?></td>
                  <td><?= get_status_badge($leave['status']) ?></td>

                  <?php if( $is_admin): ?>
                        <td class="text-center">
                          <button type="button" class="btn btn-outline-success approveLeave" data-id="<?= $leave[ 'id' ] ?>">Approve</button>
                          <button type="button" class="btn btn-outline-danger rejectLeave" data-id="<?= $leave[ 'id' ] ?>">Reject</button>
                        </td>
                    <?php elseif(  $is_user && $leave['status'] == 'pending' ): ?>
                          <td class="text-center">
                            <button type="button" class="btn btn-outline-danger deleteLeave" data-id="<?= $leave[ 'id' ] ?>">Delete</button>
                          </td>

                <?php endif; ?>
              </tr>
          <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php 
      $total_page = ceil( $total/2 );
      $page = isset( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : 1;
      ?>

<div aria-label="Page navigation example" class="text-center">
  <ul class="pagination">
    <li class="page-item">
      <?php if( $page > 1 ): ?>
      <a class="page-link"href="index.php?c=leave&page=<?= $page-1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
      <?php endif; ?>
              
      <?php
      

      for( $i = 1; $i <= $total_page; $i++ ) { ?>
        <li class="page-item"><a class="page-link" href="index.php?c=leave&page=<?= $i?> "><?= $i?></a></li>
        <?php } ?>
        <?php if( $page < $total_page) :?>
      <a class="page-link" href="index.php?c=leave&page=<?= $page+1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
      <?php endif;?>
    </li>
  </ul>
</div>



