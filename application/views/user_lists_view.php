
<div class="my-3 text-center">
    <button id="createUserBtn" class="btn btn-outline-success">Create New User</button>
</div>

<div>
    <table class="table table-striped table-light">
    <thead>
        <tr class="table-success text-center">
            <th scope="col">User ID</th>
            <th scope="col">User Name</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $users as $i => $user ): ?>
        <tr class="text-center">
            <td><?php  echo ++$i ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php  echo $user['email']; ?></td>
            <td class="text-center">
              <button type="button" class="btn btn-outline-info editUser" data-id="<?= $user[ 'id' ]?>">Edit</button>
              <button type="button" class="btn btn-outline-danger deleteUser" data-id="<?= $user[ 'id' ] ?>">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- Modal for Create User Form -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
      </div>
      <div class="modal-body">
        <!-- Form for creating a new user -->
        <form method="POST" action="index.php?c=user&m=save">
          <input type="hidden" id="userid" name="id">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success" >Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
