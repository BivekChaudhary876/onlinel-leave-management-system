<div class="modal fade" id="createHolidayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Holiday</h5>
      </div>

      <div class="modal-body">

        <form method="POST" action="holiday/save">
          <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="from_date">From</label>
            <input type="date" class="form-control" id="from_date" name="from_date" placeholder="Enter Starting Date">
          </div>
          <div class="form-group">
            <label for="to_date">To</label>
            <input type="date" class="form-control" id="to_date" name="to_date" placeholder="Enter End Date">
          </div>
          <div class="form-group">
            <label for="events">Events</label>
            <textarea class="form-control" id="event" name="event" rows="3" placeholder="Enter holiday events" required></textarea>
          </div>
          <div class="modal-footer justify-content-center">
            <input type="submit" class="btn btn-success"></input>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if ( is_admin() ) : ?>

  <div class="my-3 text-start">
    <button id="createHolidayBtn" class="btn btn-outline-success">Add new Holiday</button>
  </div>
<?php endif; ?>

<div class="my-3">
  <table class="table table-striped table-light">
    <thead>
      <tr class="table-success text-start">
        <th scope="col">S.No</th>
        <th scope="col">Event</th>
        <th scope="col">Date</th>
          <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($holidays as $key => $holiday) : ?>
        <tr class="text-start">
          <td><?= ( indexing() + $key + 1 ) ?></td>
          <td><?= $holiday[ 'event' ] ?></td>
          <td><?= $holiday[ 'created_date' ] ?></td>
          <td class="text-start">
              <?php if ( is_admin() ) : ?>
              <button class="btn btn-outline-info edit-holiday" data-id="<?= $holiday[ 'id' ] ?>">Edit</button>
              <button class="btn btn-outline-danger delete-holiday" data-id="<?= $holiday[ 'id' ] ?>">Delete</button>
              <?php endif; ?>
              <a href='holiday/details/<?php echo $holiday[ 'id' ]; ?>'"><button class="btn btn-outline-primary">View </button></a>
            </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<?php
pagination([
  'controller' => 'holiday',
  'total' => $total
]);?>


<script>
$( "#draggable" ).draggable();
$( "#drag" ).draggable();
</script>