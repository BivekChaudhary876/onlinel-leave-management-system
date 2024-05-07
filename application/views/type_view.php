<div class="modal fade" id="create-type-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Add Leave Type</h5>
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
    <button id="create-type-btn" class="btn btn-outline-success">Add New Leave Type</button>
  </div>
<?php endif; ?>

<div class="my-3">
  <table class="table table-striped table-light">
    <thead>
      <tr class="table-success text-start">
        <th scope="col">S.No</th>
        <th scope="col">Name</th>
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
          <?php if ( is_admin() ) : ?>
            <td class="text-start">
              <button class="btn-edit edit-type" data-id="<?= $type[ 'id' ] ?>"><?php echo edit();?></button>
              <button class="btn-delete delete-type" data-id="<?= $type[ 'id' ] ?>"><?php echo delete()?></button>
              <a href="type/details/<?php echo $type[ 'id' ]?>"><?php echo view();?></a>
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