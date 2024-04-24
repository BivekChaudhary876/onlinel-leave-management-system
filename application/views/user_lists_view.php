<?php if( is_admin() ) { ?>
<div class="my-3 text-center">
    <button id="createUserBtn" class="btn btn-outline-success">Create New User</button>
</div



<div class="modal fade" id="viewEmpModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info text-white">
				</div>
				<div class="modal-body">
          <table class="table table-striped table-light">
            <thead>
                <tr class="table-success text-center">
                    <th scope="col">S.No</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Department</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $users as $i => $user ): ?>
                <tr class="text-center">
                    <td><?php  echo ++$i ?></td>
                    <td><?php echo $user[ 'username' ]; ?></td>
                    <td><?php  echo $user[ 'email'] ; ?></td>
                    <td><?php echo $user[ 'department' ]; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-outline-info editUser" data-id="<?= $user[ 'id' ]?>">Edit</button>
                      <button type="button" class="btn btn-outline-danger deleteUser" data-id="<?= $user[ 'id' ] ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
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
        <form method="POST" action="index.php?c=user&m=save">
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
            <button type="submit" class="btn btn-success createUser" >Create</button>
          </div>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>


<?php 
      $total_page = ceil( $total_data/2 );
      $page = isset( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : 1;
      ?>

<div aria-label="Page navigation example" class="text-center">
  <ul class="pagination">
    <li class="page-item">
      <?php if( $page > 1 ): ?>
      <a class="page-link"href="index.php?c=user&m=list&page=<?= $page-1; ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
      <?php endif; ?>
              
      <?php
      

      for( $i = 1; $i <= $total_page; $i++ ) { ?>
        <li class="page-item"><a class="page-link" href="index.php?c=user&m=list&page=<?= $i?> "><?= $i ?></a></li>
        <?php } ?>
        <?php if( $page < $total_page ) :?>
      <a class="page-link" href="index.php?c=user&m=list&page=<?= $page+1; ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
      <?php endif;?>
    </li>
  </ul>
</div>



