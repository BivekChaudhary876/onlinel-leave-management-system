<form method="POST" action="leave/save">
	<div class="form-content">
		<input type="hidden" id="id" name="id"> 
		<input type="hidden" name="user_id" value=" <?php echo get_current_user_id(); ?> ">
		<label class="form-control-label">Leave Type</label>
		<select name="type_id" class="input">
			<option value="">Select Leave Type</option>
			<?php foreach( $leave_types as $type ): ?>
				<option value="<?= $type[ 'id' ] ?>"><?= $type[ 'name' ]?></option>
			<?php endforeach; ?>
		</select>
		<label for="from_date" class="form-control-label">From</label>
		<input type="date" class="input" name="from_date" placeholder="Enter Leave From"/>
		<label for="to_date">To</label>
		<input type="date" class="input" id="to_date" name="to_date" placeholder="Enter Leave To"/>
		<label for="description">Descriptions</label>
		<textarea class="input" id="description" name="description" rows="3" placeholder="Enter Descriptions"></textarea>
		<button type="submit" class="button">Add/Update</button>
	</div>
</form>

