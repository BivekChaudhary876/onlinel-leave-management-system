<div class="option">
	<?php if (is_user( ) ) : ?>
		<button class="open-app-modal button">Add Leave</button>
	<?php endif; ?>
	<div class="filter">
		<form method="GET" action="">
			<select name="selected_status" class="select">
				<option value="">Select Status</option>
				<?php
				$selected_status = isset( $_GET[ 'selected_status' ] ) ? $_GET[ 'selected_status' ] : '';
				foreach ( $leave_status as $status ) :
					$is_selected = ( $status[ 'status' ] == $selected_status ) ? 'selected' : '';
					?>
					<option value="<?php echo $status[ 'status' ]; ?>" <?php echo $is_selected ?>><?php echo ucfirst( $status[ 'status' ] ); ?></option>
				<?php endforeach; ?>
			</select>

			<select name="selected_user" class="select">
				<?php if ( is_admin( ) ) : ?>
					<option value="0">Select User</option>
				<?php endif; ?>
				<?php
				$selected_user = isset( $_GET[ 'selected_user' ] ) ? $_GET[ 'selected_user' ] : '0';
				foreach ( $users as $user ) :
					$is_selected = ( $user[ 'id' ] == $selected_user ) ? 'selected' : '';
					?>
					<option value="<?php echo $user[ 'id' ]; ?>" <?php echo $is_selected ; ?>><?php echo $user[ 'username' ]; ?></option>
				<?php endforeach; ?>
			</select>

			<input type="date" name="from_date" placeholder="From" class="select" value="<?php echo isset( $_GET[ 'from_date' ] ) ? $_GET[ 'from_date' ] : '' ?>" />
			<input type="date" name="to_date" placeholder="To" class="select" value="<?php echo isset( $_GET[ 'to_date' ] ) ? $_GET[ 'to_date' ] : '' ?>" />
			<input type="submit" value="Filter" class="button">
		</form>
		<div class="export">
			<form method="GET" action="">
				<input type="hidden" name="selected_status" value="<?php echo isset( $_GET[ 'selected_status' ] ) ? $_GET[ 'selected_status' ] : ''; ?>" />
				<input type="hidden" name="selected_user" value="<?php echo isset( $_GET[ 'selected_user' ] ) ? $_GET[ 'selected_user' ] : ''; ?>" />
				<input type="hidden" name="from_date" value="<?php echo isset( $_GET[ 'from_date' ] ) ? $_GET[ 'from_date' ] : ''; ?>" />
				<input type="hidden" name="to_date" value="<?php echo isset( $_GET[ 'to_date' ] ) ? $_GET[ 'to_date' ] : ''; ?>" />
				<input type="hidden" name="export" value="1" />
				<?php if( is_admin() ):?>
					<input type="submit" value="Export Report" class="export-btn">
				<?php endif;?>
			</form>
		</div>
	</div>
</div>
<div class="table-container">
	<table class="table table-light table-content">
		<thead>
			<tr class="table-secondary">
				<th scope="col">S.No</th>
				<?php if ( is_admin( ) ) : ?>
					<th scope="col">Name</th>
				<?php endif; ?>
				<th scope="col">Type</th>
				<th scope="col">Status</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $leaves as $key => $leave ) : ?>
				<tr>
					<td><?php echo esc_attr(indexing( ) + $key + 1 ); ?></td>
					<?php if ( is_admin( ) ) : ?>
						<td><?php echo esc_attr( $leave[ 'username' ] ); ?></td>
					<?php endif; ?>
					<td><?php echo esc_attr( $leave[ 'leave_type' ] ); ?></td>
					<td class="status"><?php echo get_status_badge( $leave[ 'status' ] ); ?></td>
					<td data-label="Actions">
						<?php if ( is_admin( ) ) : ?>
							<?php if ( $leave[ 'status' ] == 'pending' ) : ?>
								<button class="approved-btn change-leave-status actions" data-id="<?php echo $leave[ 'id' ]; ?>" data-status="approved">Approve</button>
								<button class="rejected-btn change-leave-status actions" data-id="<?php echo $leave[ 'id' ]; ?>" data-status="rejected">Reject</button>
							<?php elseif ( $leave[ 'status' ] == 'approved' ) : ?>
								<button class="rejected-btn change-leave-status actions" data-id="<?php echo $leave[ 'id' ]; ?>" data-status="rejected">Reject</button>
							<?php else : ?>
								<button class="approved-btn change-leave-status actions" data-id="<?php echo $leave[ 'id' ]; ?>" data-status="approved">Approve</button>
							<?php endif; ?>
						<?php endif; ?>
						<button class="btn-view"><a href="leave/details/<?php echo $leave[ 'id' ]; ?>"><?php echo icon( "view" ); ?></a></button>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>



<!-- pagination -->
<?php
pagination([
	'controller' => 'leave',
	'total' => $total
] );
?>
