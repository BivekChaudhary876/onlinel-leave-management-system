<!-- Modal for Adding/Editing Holidays -->
<div class="modal fade" id="createHolidayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Holiday</h5>
      </div>
      <div class="modal-body">
        <form id="createHolidayForm" method="POST" action="holiday/save">
          <input type="hidden" id="id" name="id"> 
          <div class="form-group">
            <label for="from_date">From</label>
            <input type="date" class="form-control" id="from_date" name="from_date"> 
          </div>
          <div class="form-group">
            <label for="to_date">To</label>
            <input type="date" class="form-control" id="to_date" name="to_date"> 
          </div>
          <div class="form-group">
            <label for="event">Event</label>
            <textarea class="form-control" id="event" name="event" rows="3" required></textarea> 
          </div>
          <div class="modal-footer justify-content-center">
            <input type="submit" class="btn btn-success" id="submitBtn"> 
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if ( is_admin() ) : ?>
  <div class="my-3 text-start">
    <button id="createHolidayBtn" class="btn btn-outline-success">Add New Holiday</button>
  </div>
<?php endif; ?>

<!-- Holiday Table -->
<div class="my-3">
  <table class="table table-striped table-light">
    <thead>
      <tr class="table-success text-start">
        <th scope="col">S.No</th>
        <th scope="col">Event</th>
        <th scope="col">Date</th>
        <?php if ( is_admin() ) : ?>
          <th scope="col">Actions</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($holidays as $key => $holiday) : ?>
        <tr data-id="<?= $holiday[ 'id' ] ?>" data-from_date="<?= $holiday[ 'from_date' ] ?>" data-to_date="<?= $holiday[ 'to_date' ] ?>" data-event="<?= $holiday[ 'event' ] ?>">
          <td><?php echo ( indexing() + $key+1 ) ?></td>
          <td><?php echo $holiday[ 'event' ] ?></td>
          <td><?php echo $holiday[ 'created_date' ] ?></td>
          <?php if ( is_admin() ) : ?>
            <td class="text-start">
              <button class="btn btn-outline-info edit-holiday" data-id="<?= $holiday[ 'id' ] ?>">Edit</button>
              <button class="btn btn-outline-danger delete-holiday" data-id="<?= $holiday[ 'id' ] ?>">Delete</button>
              <a href="holiday/details/<?= $holiday[ 'id' ] ?>"><button class="btn btn-outline-primary">View</button></a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Pagination -->
<?php pagination([
  'controller' => 'holiday',
  'total' => $total,
]); ?>

