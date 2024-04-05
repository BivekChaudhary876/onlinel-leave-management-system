$(document).ready(function () {
	$('#createUserBtn').click(function () {
		// Show the modal
		$('#createUserModal').modal('show')
	})

	$('.editUser').click(function () {
		var userId = $(this).data('id')
		var username = $(this).closest('tr').find('td:eq(1)').text()
		var email = $(this).closest('tr').find('td:eq(2)').text()

		// Populate the modal with user data
		$('#userid').val(userId)
		$('#username').val(username)
		$('#email').val(email)

		// Show the modal
		$('#createUserModal').modal('show')
	})

	// Function to handle "Delete" button click
	$('.deleteUser').click(function () {
		var userId = $(this).data('id') // Get the user ID of the selected row

		// Confirm delete
		if (confirm('Are you sure you want to delete this user?')) {
			// AJAX request to delete the user
			$.ajax({
				type: 'POST',
				url: '?c=user&m=deleteUser',
				data: {
					userId: userId,
				},
				success: function (response) {
					// Handle success response
					console.log(response) // Log the response from the server
					// Assuming response is a JSON object with success status
					if (response.success) {
						// Fade out and remove the deleted user row from the table
						$('tr[data-userid="' + userId + '"]').fadeOut(500, function () {
							$(this).remove()
						})
					}
				},
				error: function (xhr, status, error) {
					// Handle error response
					console.error(xhr.responseText) // Log the error response from the server
					// You can display an error message to the user
					alert('An error occurred while deleting the user.')
				},
				complete: function (res) {
					location.reload()
				},
			})
		}
	})
})

$(document).ready(function () {
	$('#showHolidaysBtn').click(function () {
		var year = $('#yearSelect').val()
		var month = $('#monthSelect').val()

		// AJAX request to fetch holidays
		$.ajax({
			url: '?c=user', // Replace with your endpoint
			type: 'POST',
			data: { year: year, month: month },
			dataType: 'json',
			success: function (response) {
				var holidaysHtml = '<h3>Holidays</h3><ul>'
				$.each(response, function (index, holiday) {
					// Convert date string to Date object
					var holidayDate = new Date(holiday.date)
					// Get day of the week (0 for Sunday, 1 for Monday, etc.)
					var dayOfWeek = holidayDate.getDay()
					// Array to map day of the week to its name
					var daysOfWeek = [
						'Sunday',
						'Monday',
						'Tuesday',
						'Wednesday',
						'Thursday',
						'Friday',
						'Saturday',
					]
					// Get day name from the array
					var dayName = daysOfWeek[dayOfWeek]
					// Add holiday to HTML
					holidaysHtml +=
						'<li>' +
						holiday.date +
						' (' +
						dayName +
						'): ' +
						holiday.name +
						'</li>'
				})
				holidaysHtml += '</ul>'
				$('#holidaysContainer').html(holidaysHtml)
			},
			error: function (xhr, status, error) {
				console.error('Error fetching holidays:', error)
			},
		})
	})
})
