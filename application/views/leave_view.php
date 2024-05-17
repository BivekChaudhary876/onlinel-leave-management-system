<div class="main">
	<div class="option">
		<?php if( is_user() ){?>
			<button class="open-app-modal button">Add Leave</button>
		<?php } ?>
		<div class="filter">
		<form method="GET" action="">
			<select name="selected_status" class="select">
				<option value="">Select Status</option>
				<?php
				$selected_status = isset( $_GET[ 'selected_status' ] ) ? $_GET[ 'selected_status' ] : '';
				foreach ($leave_status as $status) :
					$is_selected = ( $status[ 'status' ] == $selected_status ) ? 'selected' : '';
					?>
					<option value="<?= $status[ 'status' ] ?>" <?= $is_selected ?>><?= ucfirst( $status[ 'status' ] ) ?></option>
				<?php endforeach; ?>
			</select>

			<select name="selected_user" class="select">
				<?php if( is_admin() ) : ?>
					<option value="0">Select User</option>
				<?php endif; ?>
				<?php
				$selected_user = isset($_GET['selected_user']) ? $_GET['selected_user'] : '0';
				foreach ($users as $user) : 
					$is_selected = ( $user[ 'id' ] == $selected_user) ? 'selected' : '';?>
					<option value="<?= $user[ 'id' ] ?>" <?= $is_selected ?> ><?= $user['username'] ?></option>
				<?php endforeach; ?> 
			</select>

			<input type="date" name="from_date" placeholder="From" class="select"
			value="<?= isset( $_GET[ 'from_date' ] ) ? $_GET[ 'from_date' ] : '' ?>" />
			<input type="date" name="to_date" placeholder="To" class="select"
			value="<?= isset( $_GET[ 'to_date' ] ) ? $_GET[ 'to_date' ] : '' ?>" />
			<input type="submit" value="Filter" class="button">
		</form>
	</div>
	</div>
	<table class="table table-light table-content">
		<thead>
			<tr class="table-secondary">
				<th scope="col">S.No</th>
				<?php if( is_admin() ):?>
					<th scope="col">Name</th>
				<?php endif;?>
				<th scope="col">Type</th>
				<th scope="col">Status</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $leaves as $key => $leave ) : ?>
				<tr> 
					<td><?php  echo esc_attr( ( indexing() + $key+1 ) ); ?></td>
					<?php if( is_admin() ): ?>
						<td><?php echo esc_attr( $leave[ 'username' ] ); ?></td>
					<?php endif; ?>
					<td><?php echo esc_attr( $leave[ 'leave_type' ] ); ?></td>
					<td class="status"><?php echo get_status_badge( $leave[ 'status' ] ) ; ?></td>
					<td>
						<?php if( is_admin() ) :?>
							<?php if ( $leave[ 'status' ] == 'pending' ):?>
								<button class="approved-btn change-leave-status actions" data-id="<?php echo esc_attr( $leave[ 'id' ] ); ?>" data-status="approved">Approve</button>
								<button class="rejected-btn change-leave-status actions" data-id="<?php echo esc_attr( $leave[ 'id' ] ); ?>" data-status="rejected">Reject</button>
							<?php elseif ( $leave[ 'status' ] == 'approved'):?>
								<button class="rejected-btn change-leave-status actions" data-id="<?php echo esc_attr( $leave[ 'id' ] ); ?>" data-status="rejected">Reject</button>
							<?php else:?>
								<button class="approved-btn change-leave-status actions" data-id="<?php echo esc_attr( $leave[ 'id' ] ); ?>" data-status="approved">Approve</button>
							<?php endif;
						endif; ?>
						<a href="leave/details/<?php echo esc_attr( $leave[ 'id' ] ); ?>"><?php echo icon( "view" ); ?></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
</div>

<!-- pagination -->
<?php
pagination([
	'controller' => 'leave',
	'total' => $total
]);
?>

