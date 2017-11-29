<h3><?php echo $title; ?></h3>
<?php echo form_open('users/update_manage_user'.'/'.@$get_manage_user['User_id']); ?>
	<div class="col-md-4 col-md-offset-2">
		<div class="form-group">
			<label>Firstname:</label>
			<input type="text" class="form-control" name="firstname" placeholder="FirstName" value="<?php echo @$get_manage_user['Firstname']; ?>" required>
		</div>	
	</div>	
	<div class="col-md-4 ">
		<div class="form-group">
			<label>Lastname</label>
			<input type="text" class="form-control" name="lastname" placeholder="LastName" value="<?php echo @$get_manage_user['Lastname']; ?>" required>
		</div>
	</div>
		
	<div class="col-md-8 col-md-offset-2">
	<div class="form-group">
		<label>Email</label>
		<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo @$get_manage_user['Email']; ?>" required>
	</div>
<?php if(empty(@$get_manage_user['Password'])){?>	
	<div class="form-group">
		<label>Password</label>
		<input type="text" class="form-control" name="password" placeholder="Password" required>
	</div>
	<div class="form-group">
		<label>Confirm Password</label>
		<input type="text" class="form-control" name="password2" placeholder="Confirm Password">
	</div>
<?php } ?>				
	<div class="form-group">
		<label>Designation</label>
		<select class="form-control" name="designation" id="designation" >
			    <option value="">Select Designation</option>
			    <?php foreach($all_designations as $kk=>$vv){ ?>
			    <option <?php if($get_manage_user['Designation']==$vv['designation_id']){echo 'Selected="Selected"';}  ?>  value="<?php echo $vv['designation_id']; ?>"><?php echo $vv['designation_name']; ?></option>
			    <?php } ?>
			</select>
		<!-- <input type="text" class="form-control" name="designation" value="<?php echo @$get_manage_user['designation_name']; ?>" placeholder="Designation" required> -->
	</div>
	<div class="form-group">
		<label>TeamLead</label>
		<input type="text" class="form-control" name="team_lead" placeholder="TeamLead" value="<?php echo @$get_manage_user['Team_lead']; ?>" required>
	</div>
	<div class="form-group">
		<label>User Type</label>
		<select name="user_type" id="user_type" class="form-control" required>
			<option value="">Please Select</option>
			<option <?php if(@$get_manage_user['User_type']=='Admin'){echo 'selected="selected"'; } ?> value="Admin">Admin</option>
			<option <?php if(@$get_manage_user['User_type']=='Member'){echo 'selected="selected"'; } ?> value="Member">Member</option>
			<option <?php if(@$get_manage_user['User_type']=='TeamLead'){echo 'selected="selected"'; } ?> value="TeamLead">TeamLead</option>
		</select>
	</div>	
	<input type="hidden" name="manage_user_added_by" value="<?php echo $this->session->userdata('user_id'); ?>" >
	<button type="submit" class="btn btn-primary"><?php if(empty($get_manage_user)){ echo 'Add';}else{echo 'Update';} ?></button>
</div>		
<?php echo form_close(); ?>