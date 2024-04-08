<div class="col-8">
    <p>Hello from dashboard view</p>
</div>

<div>
    <table class="table table-striped table-light">
    <thead>
        <tr class="table-success text-center">
            <th scope="col">Holiday ID</th>
            <th scope="col">Year</th>
            <th scope="col">Month</th>
            <th scope="col">Day</th>
            <th scope="col">Event</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $holidays as $j => $holiday ): ?>
        <tr class="text-center">
            <td><?= ++$j ?></td>
            <td><?= $holiday[ 'year' ] ?></td>
            <td><?= $holiday[ 'month' ] ?></td>
            <td><?= $holiday[ 'day' ] ?></td>
            <td><?= $holiday[ 'event' ] ?></td>
            <td class="text-center">
              <button type="button" class="btn btn-outline-info editHoliday" data-id="<?= $holiday[ 'id' ] ?>">Edit</button>
              <button type="button" class="btn btn-outline-danger deleteHoliday" data-id="<?= $holiday[ 'id' ] ?>">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

