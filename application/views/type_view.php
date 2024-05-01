<div class="modal fade" id="createLeaveTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Leave Type</h5>
      </div>
      <div class="modal-body">
        <form method="POST" action="type/save">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="name">Leavve Type</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Leave Type" required>
          </div>
          <div class="modal-footer justify-content-center">
            <input type="submit" class="btn btn-success" id="submitBtn"></input>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if ( is_admin() ) : ?>
  <div class="my-3 text-start">
    <button id="creatLeaveTypeBtn" class="btn btn-outline-success">Add New Leave Type</button>
  </div>
<?php endif; ?>

<div class="my-3">
  <table class="table table-striped table-light">
    <thead>
      <tr class="table-success text-start">
        <th scope="col">S.No</th>
        <th scope="col">Name</th>
        <th scope="col">Date</th>
        <?php if ( is_admin() ) : ?>
          <th scope="col">Actions</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ( $types as $key => $type ) : ?>
        <tr class="text-start">
          <td><?php echo ( indexing() + $key + 1 ) ?></td>
          <td><?php echo $type[ 'name' ] ?></td>
          <td><?php echo $type[ 'created_date' ] ?></td>
          <?php if ( is_admin() ) : ?>
            <td class="text-start">
              <button class="btn btn-outline-info edit-type" data-id="<?= $type[ 'id' ] ?>">Edit</button>
              <button class="btn btn-outline-danger delete-type" data-id="<?= $type[ 'id' ] ?>">Delete</button>
              <a href="type/details/<?php echo $type[ 'id' ]?>"><button class="btn btn-outline-primary">View</button></a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div>
  <h1></h1>
</div>

<?php
pagination([
  'total' => $total,
  'controller' => 'type'
]);
?>