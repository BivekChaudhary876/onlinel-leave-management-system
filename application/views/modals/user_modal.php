<form method="POST" action="user/save">
	<input type="hidden" id="id" name="id">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="input" id="username" name="username" placeholder="Enter Username">
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" class="input" id="email" name="email" placeholder="Enter Email">
	</div>
	<div>
		<label>Gender</label><br>
		<input type="radio" name="gender" id="male" value="Male">
		<label for="male">Male</label>
		<input type="radio" name="gender" id="female" value="Female">
		<label for="female">Female</label>
	</div>
	<div class="form-group">
		<label for="birth_date">Birth Date</label>
		<input type="date" class="input" id="birth_date" name="birth_date">
	</div>
	<div class="form-group">
		<label class="form-control-label">Department</label>
		<select id="department" name="department" class="input">
			<option value="">Select Department</option>
			<option value="HR">HR</option>
			<option value="Development">Development</option>
			<option value="UI/UX">UI/UX</option>
			<option value="Finance">Finance</option>
			<option value="Customer Support">Customer Support</option>
		</select>
	</div>
	<div class="form-group">
		<label for="address">Address</label>
		<input type="text" class="input" id="address" name="address" placeholder="Enter Address">
	</div>
	<div class="form-group">
		<label for="phone">Contact</label>
		<input type="number" class="input" id="phone" name="phone" placeholder="Enter Contact">
	</div>
	<div class="form-group">
		<label for="password" class="input-label">Password</label>
		<input type="password" class="input" id="password" name="password" placeholder="Enter Password">
	</div>
	<div class="modal-footer">
		<button type="submit" id="submit-btn" class="button">Add/Update</button>
	</div>
</form>