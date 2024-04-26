<!-- Holiday Form  -->
<div class="modal fade" id="createLeaveTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-started" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Leave Type</h5>
      </div>
      
      <div class="modal-body">
        <!-- Form for adding a new holiday -->
        <form method="POST" action="type/save">
            <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="name">Leave Type</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Leave Type" required>
          </div>
          <div class="modal-footer justify-content-start">
            <input type="submit" class="btn btn-success"></input>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if ( is_admin() ): ?>
<!-- Display the table of holiday list -->
<div class="my-3 text-start">
    <button id="creatLeaveTypeBtn" class="btn btn-outline-success">Add New Leave Type</button>
</div>
<?php endif; ?>

<div class="my-3">
    <table class="table table-striped table-light">
    <thead>
        <tr class="table-success text-start">
            <th scope="col">S.No</th>
            <th scope="col">Type</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $types as $key => $type): ?>
          <tr class="text-start">
              <td><?php echo ( indexing() + $key+1 ) ?></td>
              <td><?php echo $type[ 'name' ] ?></td>
              <td class="text-start">
                <button type="button" class="btn btn-outline-info editType" data-id="<?php echo  $type[ 'id' ]?>">Edit</button>
                <button type="button" class="btn btn-outline-danger deleteType" data-id="<?php echo  $type[ 'id' ] ?>">Delete</button>
              </td>
          </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php
    pagination([
      'total' => $total,
      'controller' => 'type'
    ]);
?>

