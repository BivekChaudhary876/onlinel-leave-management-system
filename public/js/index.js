var $http = {
	defaults: function ($e) {
		var that = this
		return {
			beforeSend: function () {
				$e.addClass('ajax-loading')
			},
			complete: function () {
				$e.removeClass('ajax-loading')
				if (typeof that.complete === 'function') {
					that.args.complete()
				}
			},
		}
	},
	post: function (args, $e) {
		this.args = args
		$.ajax({
			...args,
			type: 'POST',
			...this.defaults($e),
		})
	},
	get: function (args, $e) {
		$.ajax({
			...args,
			type: 'GET',
			...this.defaults($e),
		})
	},
}

$(document).ready(function () {
	$('.draggable-widget').draggable({
		containment: 'document',
		revert: 'invalid',
		zIndex: 1000,
	})

	$('.droppable-widget-area').droppable({
		drop: function (event, ui) {
			const droppedWidget = ui.draggable
			const $dropArea = $(this)

			$dropArea.append(droppedWidget)

			droppedWidget.css({
				top: 0,
				left: 0,
				position: 'relative',
			})

			var widget_order = {
				first: [],
				second: [],
				third: [],
			}

			$('#widget-area-first .draggable-widget').each(function () {
				widget_order['first'].push($(this).attr('id'))
			})

			$('#widget-area-second .draggable-widget').each(function () {
				widget_order['second'].push($(this).attr('id'))
			})

			$('#widget-area-third .draggable-widget').each(function () {
				widget_order['third'].push($(this).attr('id'))
			})

			$http.post(
				{
					url: 'dashboard/save_widget_order',
					data: {
						widget_order: widget_order,
					},
				},
				$(this)
			)
		},
	})

	$('#createUserBtn').click(function () {
		$('#id').val('')
		$('#username').val('')
		$('#email').val('')
		$('#department').val('')
		$('#submitBtn').val('Create')
		$('#createUserModal').modal('show')
	})

	$('.edit-user').click(function () {
		var id = $(this).data('id')
		var username = $(this).closest('tr').find('td:eq(1)').text()
		var email = $(this).closest('tr').find('td:eq(2)').text()
		var department = $(this).closest('tr').find('td:eq(3)').text()

		$('#id').val(id)
		$('#username').val(username)
		$('#email').val(email)
		$('#department').val(department)
		$('#exampleModalLabel').text('Edit User')
		$('#submitBtn').val('Update')
		$('#createUserModal').modal('show')
	})

	function delete_user(id, $element) {
		if (confirm('Are you sure you want to delete this user?')) {
			$http.post(
				{
					url: 'user/delete',
					data: {
						id: id,
					},
					success: function (response) {
						var res = JSON.parse(response)
						if (res.success) {
							$element.fadeOut(500, function () {
								$(this).remove()
							})
						} else {
							alert('Error: ' + res.message)
						}
					},
					error: function (xhr, status, error) {
						console.error('Error:', xhr.responseText)
						alert('An error occurred while deleting the user.')
					},
				},
				$element
			)
		}
	}

	$('.delete-user').click(function () {
		var id = $(this).data('id')
		var $row = $(this).closest('tr')
		delete_user(id, $row)
	})

	$('#createLeaveBtn').click(function () {
		$('#createLeaveModal').modal('show')
	})

	$('#viewBtn').click(function () {
		$('#viewModal').modal('show')
	})

	$('#totalLeaveBtn').click(function () {
		$('#totalLeaveModal').modal('show')
	})

	$('#pendingBtn').click(function () {
		$('#pendingModal').modal('show')
	})

	$('#approvedBtn').click(function () {
		$('#approvedModal').modal('show')
	})

	$('#rejectedBtn').click(function () {
		$('#rejectedModal').modal('show')
	})

	$('.change-leave-status').click(function (e) {
		e.preventDefault()

		var id = $(this).data('id'),
			status = $(this).data('status'),
			$status = $(this).closest('tr').find('.status')

		$http.post(
			{
				url: 'leave/save',
				data: {
					id: id,
					status: status,
				},
				success: function () {
					// Update the status cell in the table
					$status.html(
						'<span class="badge text-bg-' +
							(status === 'approved' ? 'success' : 'danger') +
							'">' +
							status +
							'</span>'
					)
				},
				error: function (xhr) {
					// Handle error response
					console.error(xhr.responseText)
					alert('An error occurred while updating the leave status.')
				},
			},
			$(this)
		)
	})

	$('#createHolidayBtn').click(function () {
		$('#id').val('')
		$('#from_date').val('')
		$('#to_date').val('')
		$('#event').val('')
		$('#submitBtn').val('Create')
		$('#createHolidayModal').modal('show')
	})

	$('.edit-holiday').click(function () {
		var $row = $(this).closest('tr')
		var id = $row.data('id')
		var from_date = $row.data('from_date')
		var to_date = $row.data('to_date')
		var event = $row.data('event')

		console.log(
			'Editing holiday with ID:',
			id,
			'From:',
			from_date,
			'To:',
			to_date,
			'Event:',
			event
		)

		$('#id').val(id)
		$('#from_date').val(from_date)
		$('#to_date').val(to_date)
		$('#event').val(event)
		$('#exampleModalLabel').text('Edit Holiday')
		$('#createHolidayForm').attr('action', 'holiday/save')
		$('#submitBtn').val('Update')
		$('#createHolidayModal').modal('show')
	})

	function delete_holiday(id, $element) {
		if (confirm('Are you sure you want to delete this holiday?')) {
			$http.post(
				{
					url: 'holiday/delete',
					data: {
						id: id,
					},
					success: function (response) {
						var res = JSON.parse(response)
						if (res.success) {
							$element.fadeOut(500, function () {
								$(this).remove()
							})
						} else {
							alert('Error: ' + res.message)
						}
					},
					error: function (xhr, status, error) {
						console.error('Error:', xhr.responseText)
						alert('An error occurred while deleting the user.')
					},
				},
				$element
			)
		}
	}

	$('.delete-holiday').click(function () {
		var id = $(this).data('id')
		var $row = $(this).closest('tr')
		delete_holiday(id, $row)
	})

	$('#creatLeaveTypeBtn').click(function () {
		$('#id').val('')
		$('#name').val('')
		$('#submitBtn').val('Create')
		$('#createLeaveTypeModal').modal('show')
	})

	$('.edit-type').click(function () {
		var id = $(this).data('id')
		var type = $(this).closest('tr').find('td:eq(1)').text()

		$('#id').val(id)
		$('#name').val(type)
		$('#exampleModalLabel').text('Edit Leave Type')
		$('#submitBtn').val('Update')
		$('#createLeaveTypeModal').modal('show')
	})

	function delete_type(id, $element) {
		if (confirm('Are you sure you want to delete this leave type?')) {
			$http.post(
				{
					url: 'type/delete',
					data: {
						id: id,
					},
					success: function (response) {
						var res = JSON.parse(response)
						if (res.success) {
							$element.fadeOut(500, function () {
								$(this).remove()
							})
						} else {
							alert('Error: ' + res.message)
						}
					},
					error: function (xhr, status, error) {
						console.error('Error:', xhr.responseText)
						alert('An error occurred while deleting the leave type.')
					},
				},
				$element
			)
		}
	}

	$('.delete-type').click(function () {
		var id = $(this).data('id')
		var $row = $(this).closest('tr')
		delete_type(id, $row)
	})
})
;(function () {
	function validateDaysInput() {
		var daysInput = document.getElementById('day')
		var daysValue = daysInput.value
		// Regular expression to match numbers separated by commas
		var regex = /^\d+(,\s*\d+)*$/
		if (!regex.test(daysValue)) {
			alert('Invalid input for days. Please enter numbers separated by commas.')
			return false // Return false to prevent form submission
		}
		return true // Return true if input is valid
	}

	$('#holidayForm').on('submit', function (event) {
		// Validate days input
		if (!validateDaysInput()) {
			event.preventDefault() // Prevent form submission if validation fails
		}
	})
})()

$(document).ready(function () {})
