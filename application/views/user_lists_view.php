<?php if( is_admin() ) { ?>
<div class="my-3 text-start">
    <button id="createUserBtn" class="btn btn-outline-success">Create New User</button>

    <div class="my-3">
      <table class="table table-striped table-light">
        <thead>
          <tr class="table-success text-start">
            <th scope="col">S.No</th>
            <th scope="col">User Name</th>
            <th scope="col">Email</th>
            <th scope="col">Department</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach( $users as $i => $user ): ?>
            <tr class="text-start">
              <td><?php  echo ++$i ?></td>
              <td><?php echo $user[ 'username' ]; ?></td>
              <td><?php  echo $user[ 'email'] ; ?></td>
              <td><?php echo $user[ 'department' ]; ?></td>
              <td class="text-start">
                <button type="button" class="btn btn-outline-info editUser" data-id="<?= $user[ 'id' ]?>">Edit</button>
                <button type="button" class="btn btn-outline-danger deleteUser" data-id="<?= $user[ 'id' ] ?>">Delete</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php
        // Get current page from URL
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // Calculate total pages
        $total_page = ceil($total / 2);
        // Build the query string with existing parameters
        $current_query = $_GET;
        // Remove the 'page' key if it exists
        unset($current_query['page']); 
        // Build query string from current parameters to generate URL-encoded query string from the associative (or indexed) array
        $query_string = http_build_query($current_query);
    ?>
    <!-- Create pagination -->
    <div class="text-start">
      <ul class="pagination">
        <!-- Previous button -->
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="leave?page=<?= $page - 1 ?>&<?= $query_string ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <!-- Page numbers -->
        <?php for ($i = 1; $i <= $total_page; $i++): ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="leave?page=<?= $i ?>&<?= $query_string ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <!-- Next button -->
        <li class="page-item <?= ($page >= $total_page) ? 'disabled' : '' ?>">
          <a class="page-link" href="leave?page=<?= $page + 1 ?>&<?= $query_string ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </div>
</div>

<!-- Modal for Create User Form -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
      </div>
      <div class="modal-body">
        <?php } ?>
          <!-- Form for creating a new user -->
          <form method="POST" action="user/save">
            <input type="hidden" id="userid" name="id">
            <?php if ( is_admin() ): ?>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
            <?php else: ?>
                  <div class="form-group mt-3">
                    <label for="username">Username</label>
                      <input type="text" value="<?= $_SESSION[ 'current_user' ][ 'username' ] ?>" class="form-control" id="username" name="username" placeholder="Enter Username">
            <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
            <?php if ( is_admin() ): ?>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" >
            <?php else: ?>
                        <input type="email" value="<?= $_SESSION[ 'current_user' ][ 'email' ] ?>"class="form-control" id="email" name="email" placeholder="Enter email" >
            <?php endif; ?>
                  </div>
            <?php if ( is_admin() ): ?>
                  <div class="form-group">
                      <label class="form-control-label">Department</label>
                      <select name="department" class="form-control">
                        <option value="HR">HR</option>
                        <option value="Development">Development</option>
                        <option value="UI/UX">UI/UX</option>
                        <option value="Finance">Finance</option>
                        <option value="Customer Support">Customer Support</option>
                      </select>
                    </div>
            <?php else: ?>
                  <div class="form-group">
                    <label class="form-control-label">Department</label>
                      <input type="text" value="<?= $_SESSION[ 'current_user' ][ 'department' ] ?>" class="form-control" id="department" name="department" placeholder="Enter Department">
            <?php endif; ?>
                  </div>
            <?php if ( is_admin() ): ?>
                  <div class="form-group">
                    <label for="password">Password</label>
                    
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                      <?php endif; ?>
                  </div>
            <?php if( is_admin() ){ ?>
                  <div class="modal-footer justify-content-center">
                    <input type="submit" class="btn btn-success createUser">Create</input>
                  </div>
            <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>




