<form method="POST" action="leave/save">
	<input type="hidden" name="user_id" value=" <?php echo $_SESSION[ 'current_user'  ][ 'id' ] ?> ">
	<div class="form-group">
		<label class="form-control-label">Leave Type</label>
		<select name="type_id" class="form-control">
			<option value="">Select Leave Type</option>
			<?php foreach( $leave_types as $type ): ?>
				<option value="<?= $type[ 'id' ] ?>"><?= $type[ 'name' ]?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="from_date" class="form-control-label">From</label>
		<input type="date" class="form-control" name="from_date" placeholder="Enter Leave From"/>
	</div>
	<div class="form-group">
		<label for="to_date">To</label>
		<input type="date" class="form-control" id="to_date" name="to_date" placeholder="Enter Leave To"/>
	</div>
	<div class="form-group">
		<label for="description">Descriptions</label>
		<textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Descriptions"></textarea>
	</div>

	<div class="modal-footer">
		<button type="submit" class="button">Add/Update</button>
	</div>
</form>