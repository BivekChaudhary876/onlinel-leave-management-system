<?php $role = $_SESSION[ 'current_user' ][ 'role' ]; 
$i = 1;
?>

<!-- Holiday Form  -->
<div class="modal fade" id="createLeaveTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Leave Type</h5>
      </div>
      
      <div class="modal-body">
        <!-- Form for adding a new holiday -->
        <form method="POST" action="index.php?c=type&m=save">
            <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="type">Leave Type</label>
            <input type="text" class="form-control" id="type" name="type" placeholder="Enter Leave Type" required>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if ( $role == 'admin'): ?>
<!-- Display the table of holiday list -->
<div class="my-3 text-center">
    <button id="creatLeaveTypeBtn" class="btn btn-outline-success">Add New Leave Type</button>
</div>
<?php endif; ?>

<div class="my-3">
    <table class="table table-striped table-light">
    <thead>
        <tr class="table-success text-center">
            <th scope="col">S.No</th>
            <th scope="col">Type</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $types as $type): ?>
        <tr class="text-center">
            <td><?= $i++ ?></td>
            <td><?= $type[ 'type' ] ?></td>
            <td class="text-center">
              <button type="button" class="btn btn-outline-info editType" data-id="<?= $type[ 'id' ]?>">Edit</button>
              <button type="button" class="btn btn-outline-danger deleteType" data-id="<?= $type[ 'id' ] ?>">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
