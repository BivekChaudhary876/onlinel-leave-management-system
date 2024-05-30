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

	$('.widget-action').click(function () {
		var $this = $(this),
		isChecked = $this.is(':checked'),
		$status = $(this).closest('tr').find('.status')
		$http.post(
		{
			url: 'widget/toggle_widget',
			data: {
				name: $(this).data('name'),
			},
			success: function (response) {
				if ('activate' == response.operation) {
					$this.text('Deactivate')
					$status.text('Active'), $this.prop('checked', true)
				}
				if ('deactivate' == response.operation) {
					$this.text('Activate')
					$status.text('Inactive'), $this.prop('checked', false)
				}
			},
		},
		$(this)
		)
	})

	$('.open-app-modal').click(function () {
		var data = $(this).data( 'value' );
		var $modal = $('#app-modal');
		if( data ){
			for( var i in data ){
				var $ele = $( '#'+i );

				if( $ele.length ){
					if( $ele.is( "input" ) ){
						var type = $ele.attr( 'type' );
						if( type === 'radio'){
							$$ele.attr( 'name' ).val( data[ i ] ).prop('checked', true);

						}else{
							$ele.val( data[ i ] );
						}
					}else if ($ele.is("textarea")) {
						$ele.val(data[ i ]);
					} else if ($ele.is("select")) {
						$ele.val(data[ i ]);
					}
				}
			}
		}else{
			$modal.find('input').val('');
			$modal.find('radio').prop('checked', false);
			$modal.find('select').val('');
		}

		$modal.modal('show')
	})

	function delete_item(id, $element, url, confirmMessage) {
		if (confirm(confirmMessage)) {
			$.post(
				url,
				{ id: id },
				function(response) {
					var res = JSON.parse(response);
					if (res.success) {
						$element.fadeOut(500, function() {
							$(this).remove();
						});
					} else {
						alert('Error: ' + res.message);
					}
				}
				).fail(function(xhr, status, error) {
					console.error('Error:', xhr.responseText);
					alert('An error occurred while deleting the item.');
				});
			}
		}

		$('.delete-user').click(function () {
			var id = $(this).data('id')
			var $row = $(this).closest('tr')
			delete_item(id, $row, 'user/delete', 'Are you sure you want to delete this user?')
		})

		$('.delete-department').click(function () {
			var id = $(this).data('id')
			var $row = $(this).closest('tr')
			delete_item(id, $row, 'department/delete', 'Are you sure you want to delete this department?')
		})

		$('.delete-holiday').click(function () {
			var id = $(this).data('id')
			var $row = $(this).closest('tr')
			delete_item(id, $row, 'holiday/delete','Are you sure you want to delete this holiday?')
		})

		$('.delete-type').click(function () {
			var id = $(this).data('id')
			var $row = $(this).closest('tr')
			delete_item(id, $row, 'type/delete', 'Are you sure you want to delete this leave type?')
		})

		$('.change-leave-status').click(function (e) {
			e.preventDefault()

			var id = $(this).data('id'),
			status = $(this).data('status'),
			$status = $(this).closest('tr').find('.status')

			$http.post(
			{
				url: 'leave/update_status',
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
						);
					location.reload();
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


		$('#file_to_upload').on('change', function () {
			var formData = new FormData($('#media-form')[0]);
			$http.post(
			{
				url: 'media/save',
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					location.reload();
				},
				error: function (xhr, status, error) {
					console.error('Error:', xhr.responseText);
					alert('An error occurred while uploading the file.');
				}
			},
			$(this)
			);
		});

		function delete_media(ids) {
        if (confirm('Are you sure you want to delete the selected media file(s)?')) {
            $.post(
                'media/delete',
                { ids: ids },
                function(response) {
                    var res = JSON.parse(response);
                    if (res.success) {
                        ids.forEach(function(id) {
                            $('.delete-checkbox[data-id="' + id + '"]').closest('li').fadeOut(500, function() {
                                $(this).remove();
                            });
                        });
                    } else {
                        alert('Error: ' + res.message);
                    }
                }
            ).fail(function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                alert('An error occurred while deleting the media file(s).');
            });
        }
    }

    // Delete selected media files
    $('#delete-selected').click(function () {
        var ids = [];
        $('.delete-checkbox:checked').each(function () {
            ids.push($(this).data('id'));
        });

        if (ids.length === 0) {
            alert('Please select at least one file to delete.');
            return;
        }

        delete_media(ids);
    });

	//to display file option when logo field of setting is clicked
		$('.navbar-logo').on('click', function() {
			$.ajax({
				url: 'media/list',
				method: 'GET',
				success: function(data) {
                // Display the pop-up with media files
					$('body').append('<div id="media-popup">' + data + '</div>');
					$('#media-popup').show();
				}
			});
		});

    // Functionality for selecting a media file from the pop-up
		$(document).on('click', '.media-file', function() {
			var mediaPath = $(this).data('path');
			$('.navbar-logo').attr('src', mediaPath);
        $('#logo').val(mediaPath); // Assuming you need to set the value of an input field
        $('#media-popup').remove();
    });

    // Close the pop-up if clicked outside
		$(document).on('click', function(event) {
			if (!$(event.target).closest('#media-popup, .navbar-logo').length) {
				$('#media-popup').remove();
			}
		});

	})

function toggleContent(id) {
	var element = document.getElementById(id);
	if (element.style.display === "none") {
		element.style.display = "block";
	} else {
		element.style.display = "none";
	}
}

;(function () {
	function validateDaysInput() {
		var daysInput = document.getElementById('day')
		var daysValue = daysInput.value
		var regex = /^\d+(,\s*\d+)*$/
		if (!regex.test(daysValue)) {
			alert('Invalid input for days. Please enter numbers separated by commas.')
			return false 
		}
		return true
	}

	$('#holidayForm').on('submit', function (event) {
		// Validate days input
		if (!validateDaysInput()) {
			event.preventDefault() 
		}
	})
})()





