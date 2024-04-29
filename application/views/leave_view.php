

<?php if( is_user() ) : ?>
  <div class="my-3 text-start d-flex justify-content-between">
      <button id="createLeaveBtn" class="btn btn-outline-info">Leave Apply</button>
  </div>
<?php endif; ?>
<div class="my-3 text-start">
    <div class="col">
        <div class="my-3 text-end">
            <form method="GET" action="">
              
                <select name="selected_user" class="p-1 btn border-success rounded-start rounded-end">
                    <?php if( is_admin() ) : ?>
                      <option value="0">Select User</option>
                    <?php endif; ?>
                    <?php
                        $selected_user = isset($_GET['selected_user']) ? $_GET['selected_user'] : '0';
                        foreach ($users as $user) : 
                            $is_selected = ($user['id'] == $selected_user) ? 'selected' : '';?>
                            <option value="<?= $user['id'] ?>" <?= $is_selected ?> ><?= $user['username'] ?></option>
                        <?php endforeach; ?> 
                </select>

                <input type="date" name="from_date" class="p-1 btn border-success rounded-start rounded-end" placeholder="From" 
                    value="<?= isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>" />
                <input type="date" name="to_date" class="p-1 btn border-success rounded-start rounded-end" placeholder="To"
                    value="<?= isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>" />
                <input type="submit" value="Filter" class="p-1 btn btn-outline-success">
            </form>
        </div>
    </div>

  <!-- Leave Apply -->
<div class="modal fade" id="createLeaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Leave Apply</h5>
      </div>
      <div class="modal-body">
        <!-- Form for creating a new user -->
        <form method="POST" action="leave/save"">
          <input type="hidden" name="user_id" value=" <?php echo $_SESSION[ 'current_user'  ][ 'id' ] ?> ">
          <div class="form-group">
							<label class="form-control-label">Leave Type</label>
							<select name="type_id" class="form-control">
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
        <tr class="table-success text-start">
            <th scope="col">S.No</th>
            <?php if( is_admin() ):?>
              <th scope="col">Name</th>
            <?php endif;?>
            <th scope="col">Type</th>
            <th scope="col">Status</th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $leaves as $key => $leave ) : ?>
              <tr> 
                  <td><?php  echo ( indexing() + $key+1 ) ; ?></td>
                  <?php if( is_admin() ): ?>
                        <td><?php echo $leave[ 'username' ]; ?></td>
                  <?php endif; ?>
                  <td><?php echo $leave[ 'leave_type' ]; ?></td>
                  <td class="status"><?php echo get_status_badge( $leave[ 'status' ] ) ?></td>
                  <td><?php echo $leave[ 'created_date' ]; ?></td>

                        <td>
                          <?php if( is_admin() ) :?>
                          <button class="btn btn-outline-success change-leave-status" data-id="<?= $leave[ 'id' ] ?>" data-status="approved">Approve</button>
                          <button class="btn btn-outline-danger change-leave-status" data-id="<?= $leave[ 'id' ] ?>" data-status="rejected">Reject</button>
                          <?php endif; ?>
                          <a href='leave/details/<?php echo $leave[ 'id' ]; ?>'"><button class="btn btn-outline-primary">View </button></a>
                        </td>
              </tr>
          <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- pagination -->
<?php
pagination([
  'controller' => 'leave',
  'total' => $total
]);
?>

