
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
        <?php foreach( $users as $i=>$user ): ?>
        <tr class="text-center">
            <td><?php  echo ++$i ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php  echo $user['password']; ?></td>
            <td class="text-center"><button type="button" class="btn btn-outline-info editUser" data-id="<?= $user[ 'id' ]?>">Edit</button> | <button type="button" class="btn btn-outline-danger deleteUser" data-id="<?= $user[ 'id' ] ?>">Delete</button></td>
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
        <form id="createUserForm">
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
        </form>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-success" id="createUser">Create</button>
      </div>
    </div>
  </div>
</div>


<!-- Performing the Actions Operations of the table

Edit

Delete the Users Records-->

<!-- Modal for Edit User Form -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
      </div>
      <div class="modal-body">
        <!-- Form for editing a user -->
        <form id="editUserForm">
          <input type="hidden" id="editUserId" name="editUserId">
          <div class="form-group">
            <label for="editUsername">Username</label>
            <input type="text" class="form-control" id="editUsername" name="editUsername" placeholder="Enter username">
          </div>
          <div class="form-group">
            <label for="editEmail">Email</label>
            <input type="email" class="form-control" id="editEmail" name="editEmail" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="editPassword">Password</label>
            <input type="password" class="form-control" id="editPassword" name="editPassword" placeholder="Password">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="updateUser">Update</button>
      </div>
    </div>
  </div>
</div>



<!-- JavaScript to handle AJAX and modal -->
<script>
  $( document ).ready( function() {
    $( '#createUserBtn' ).click( function() {
      // Show the modal
      $( '#createUserModal' ).modal( 'show' );
    });

    // Handle create user button click
    $( '#createUser' ).click( function() {
      // Get form data
      var formData = $( '#createUserForm' ).serialize();
      
      // Make AJAX request to add the user
      $.ajax( {
        url: '?c=user&m=save', //controller method that handles user creation
        method: 'POST',
        data: formData,
        success: function( response ) {
          // If user added successfully, close modal and do something (like refresh page)
          $( '#createUserModal' ).modal( 'hide' );
          location.reload();
        },
        error: function( xhr, status, error ) {
          // Handle errors
          console.error( error );
        }
      });
    });


    $('.editUser').click(function() {
            var userId = $(this).data('id'); 
            var username = $(this).closest('tr').find('td:eq(1)').text(); 
            var email = $(this).closest('tr').find('td:eq(2)').text();
            
            // Populate the modal with user data
            $('#editUserId').val(userId);
            $('#editUsername').val(username);
            $('#editEmail').val(email);
            
            // Show the modal
            $('#editUserModal').modal('show');
        });

        // Update User Button Click Event
        $('#updateUser').click(function() {
        // Get the data from the edit user form
        var userId = $('#editUserId').val();
        var username = $('#editUsername').val();
        var email = $('#editEmail').val();
        var password = $('#editPassword').val();

        // AJAX request to update the user
        $.ajax({
            type: 'POST',
            url: '?c=user&m=updateUser', // Replace 'update_user.php' with the actual URL for updating user data
            data: {
                userId: userId,
                username: username,
                email: email,
                password: password
            },
            success: function(response) {
                // Handle success response
                console.log(response); // Log the response from the server
                // Assuming response is a JSON object with updated user data
                // Update the row in the table with the new data
                $('#editUserModal').modal('hide'); // Hide the modal after successful update
                // Update the row in the table
                var rowToUpdate = $('td:contains(' + userId + ')').closest('tr');
                rowToUpdate.find('td:eq(1)').text(username);
                rowToUpdate.find('td:eq(2)').text(email);
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText); // Log the error response from the server
                // You can display an error message to the user
            }
        });
    });

    // Function to handle "Delete" button click
    $('.deleteUser').click(function() {
    var userId = $(this).data('id'); // Get the user ID of the selected row

    // Confirm delete
    if (confirm("Are you sure you want to delete this user?")) {
        // AJAX request to delete the user
        $.ajax({
            type: 'POST',
            url: '?c=user&m=deleteUser',
            data: {
                userId: userId
            },
            success: function(response) {
                // Handle success response
                console.log(response); // Log the response from the server
                // Assuming response is a JSON object with success status
                if (response.success) {
                    // Fade out and remove the deleted user row from the table
                    $('tr[data-userid="' + userId + '"]').fadeOut(500, function() {
                        $(this).remove();
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText); // Log the error response from the server
                // You can display an error message to the user
                alert("An error occurred while deleting the user.");
            },
            complete: function( res) {
                location.reload();
            }
        });
    }
});

  });
</script>
