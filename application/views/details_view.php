
    <table class="table table-striped table-light table-hover">
        <thead>
            <tr class="table-success text-center">
                <th scope="col">S.No</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Department</th>
                <th scope="col">Type</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach( $leave as $key => $leave_request ): ?>
            <tr class="text-center"> 
                <td><?php  echo ( ++$key) ?></td>
                <td><?= $leave_request[ 'username' ];?></td>
                <td><?= $leave_request[ 'email' ];?></td>
                <td><?= $leave_request[ 'department' ];?></td>
                <td><?php  echo $leave_request[ 'leave_type' ]; ?></td>
                <td><?php  echo $leave_request[ 'from_date' ]; ?></td>
                <td><?php  echo $leave_request[ 'to_date' ]; ?></td>
                <td><?php  echo $leave_request[ 'created_date' ]; ?></td>
                <td><?php  echo $leave_request[ 'description' ]; ?></td>
                <td><?= get_status_badge( $leave_request[ 'status' ] ) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
   </table>
  </div>
</div>
