<?php $role = $_SESSION[ 'current_user' ][ 'role' ]; 
$i = 1;
?>

<!-- Holiday Form  -->
<div class="modal fade" id="createLeaveTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Leave Type</h5>
      </div>
      
      <div class="modal-body">
        <!-- Form for adding a new holiday -->
        <form method="POST" action="index.php?c=type&m=save">
            <input type="hidden" id="id" name="id">
          <div class="form-group">
            <label for="type">Leave Type</label>
            <input type="text" class="form-control" id="type" name="type" placeholder="Enter Leave Type" required>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-success">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php if ( $role == 'admin'): ?>
<!-- Display the table of holiday list -->
<div class="my-3 text-center">
    <button id="creatLeaveTypeBtn" class="btn btn-outline-success">Add New Leave Type</button>
</div>
<?php endif; ?>

<div class="my-3">
    <table class="table table-striped table-light">
    <thead>
        <tr class="table-success text-center">
            <th scope="col">S.No</th>
            <th scope="col">Type</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $types as $type): ?>
        <tr class="text-center">
            <td><?= $i++ ?></td>
            <td><?= $type[ 'type' ] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>



<script>
  $(document).ready(function () {
    $('#creatLeaveTypeBtn').click(function () {
		// Show the modal
		$('#createLeaveTypeModal').modal('show')
	})

	$('.editType').click(function () {
		var typeId = $(this).data('id')
		var type = $(this).closest('tr').find('td:eq( 1 )').text()
		// Populate the modal with user data
		$('#id').val(typeId)
		$('#type').val(type)

		// Show the modal
		$('#createLeaveTypeModal').modal('show')
	})

	$('.deleteType').click(function () {
		var typeId = $(this).data('id') // Get the holiday ID of the selected row

		// Confirm delete
		if (confirm('Are you sure you want to delete this Leave Type?')) {
			// AJAX request to delete the holiday
			$.ajax({
				type: 'POST',
				url: '?c=type&m=delete',
				data: {
					id: leaveId,
				},
				success: function (response) {
					// Handle success response
					console.log(response) // Log the response from the server
					// Assuming response is a JSON object with success status
					if (response.success) {
						// Fade out and remove the deleted holiday row from the table
						$('tr[data-id="' + leaveId + '"]').fadeOut(500, function () {
							$(this).remove()
						})
					}
				},
				error: function (xhr, status, error) {
					// Handle error response
					console.error(xhr.responseText) // Log the error response from the server
					// You can display an error message to the leave type
					alert('An error occurred while deleting the leave type.')
				},
				complete: function (res) {
					location.reload()
				},
			})
		}
	})
})

</script>