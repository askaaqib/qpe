<?php echo validation_errors(); ?>

<?php echo form_open('users/register'); ?>
	<div class="row">
			
			<div class="col-md-12">
				<h1 class="text-center"><?= $title; ?></h1>
			</div>

			<div class="col-md-4 col-md-offset-2">
				<div class="form-group">
					<label>Firstname:</label>
					<input type="text" class="form-control" name="firstname" placeholder="FirstName" required>
				</div>	
			</div>	

			<div class="col-md-4 ">
				<div class="form-group">
					<label>Lastname</label>
					<input type="text" class="form-control" name="lastname" placeholder="LastName" required>
				</div>
			</div>
				
			<div class="col-md-8 col-md-offset-2">
			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="email" placeholder="Email">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password" placeholder="Password" required>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" class="form-control" name="password2" placeholder="Confirm Password">
			</div>			
			<div class="form-group">
				<label>Designation</label>
				<input type="text" class="form-control" name="designation" placeholder="Designation" required>
			</div>
			<div class="form-group">
				<label>User Type</label>
				<select name="user_type" id="user_type" class="form-control" required>
					<option value="">Please Select</option>
					<option value="Admin">Admin</option>
					<option value="Member">Member</option>
					<option value="TeamLead">TeamLead</option>
				</select>
			</div>
			<button type="submit" class="btn btn-primary ">Submit</button>
		</div>
	</div>
<?php echo form_close(); ?>
